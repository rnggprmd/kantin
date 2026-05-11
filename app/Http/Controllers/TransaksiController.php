<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with('user')->orderByDesc('created_at');

        if ($request->filled('search')) {
            $query->where('kode_transaksi', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tanggal_dari')) {
            $query->whereDate('created_at', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('created_at', '<=', $request->tanggal_sampai);
        }

        $transaksis = $query->paginate(15)->withQueryString();

        return view('transaksi.index', compact('transaksis'));
    }

    public function create()
    {
        $menus = Menu::with('kategori')
            ->where('is_tersedia', true)
            ->get()
            ->groupBy('kategori.nama');

        return view('transaksi.create', compact('menus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.qty' => 'required|integer|min:1',
            'metode_bayar' => 'required|in:tunai,non_tunai',
            'uang_bayar' => 'required_if:metode_bayar,tunai|nullable|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                $menu = Menu::findOrFail($item['menu_id']);

                $subtotal = $menu->harga * $item['qty'];
                $total += $subtotal;

                $itemsData[] = [
                    'menu' => $menu,
                    'qty' => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }

            $kembalian = null;
            $uangBayar = null;

            if ($request->metode_bayar === 'tunai') {
                $uangBayar = $request->uang_bayar;
                if ($uangBayar < $total) {
                    throw new \Exception('Uang bayar kurang dari total transaksi.');
                }
                $kembalian = $uangBayar - $total;
            }

            $transaksi = Transaksi::create([
                'kode_transaksi' => Transaksi::generateKode(),
                'user_id' => auth()->id(),
                'pelanggan_nama' => $request->pelanggan_nama,
                'total_harga' => $total,
                'metode_bayar' => $request->metode_bayar,
                'uang_bayar' => $uangBayar,
                'kembalian' => $kembalian,
                'status' => ($request->metode_bayar === 'tunai') ? 'selesai' : 'pending',
                'catatan' => $request->catatan,
            ]);

            foreach ($itemsData as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id' => $item['menu']->id,
                    'nama_menu' => $item['menu']->nama,
                    'harga_satuan' => $item['menu']->harga,
                    'qty' => $item['qty'],
                    'subtotal' => $item['subtotal'],
                ]);
            }

            // Handle Non-Tunai (Midtrans)
            if ($request->metode_bayar === 'non_tunai') {
                Config::$serverKey = config('services.midtrans.server_key');
                Config::$isProduction = (bool) config('services.midtrans.is_production');
                Config::$isSanitized = (bool) config('services.midtrans.is_sanitized');
                Config::$is3ds = (bool) config('services.midtrans.is_3ds');

                $params = [
                    'transaction_details' => [
                        'order_id' => $transaksi->kode_transaksi . '-' . time(),
                        'gross_amount' => (int) $transaksi->total_harga,
                    ],
                    'customer_details' => [
                        'first_name' => $request->pelanggan_nama ?: 'Pelanggan',
                    ],
                    'item_details' => collect($itemsData)->map(function($item) {
                        return [
                            'id' => $item['menu']->id,
                            'price' => (int) $item['menu']->harga,
                            'quantity' => $item['qty'],
                            'name' => $item['menu']->nama,
                        ];
                    })->toArray(),
                    'callbacks' => [
                        'finish' => route('transaksi.show', $transaksi->id),
                    ],
                ];

                try {
                    $snapToken = Snap::getSnapToken($params);
                    $transaksi->update(['snap_token' => $snapToken]);
                } catch (\Exception $e) {
                    throw new \Exception('Koneksi Midtrans Gagal: ' . $e->getMessage());
                }
            }

            DB::commit();

            if ($request->metode_bayar === 'non_tunai') {
                return redirect()->route('transaksi.show', $transaksi->id)
                    ->with('success', 'Transaksi berhasil disimpan. Silahkan lakukan pembayaran.')
                    ->with('snap_token', $snapToken);
            }

            return redirect()->route('transaksi.show', $transaksi->id)
                ->with('success', 'Transaksi berhasil disimpan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'details.menu']);
        return view('transaksi.show', compact('transaksi'));
    }

    public function destroy(Transaksi $transaksi)
    {
        // Batalkan transaksi

        $transaksi->update(['status' => 'batal']);

        return back()->with('success', 'Transaksi berhasil dibatalkan.');
    }
    public function markAsSuccess(Transaksi $transaksi)
    {
        // Security check: Only the owner (cashier) can mark as success
        if ($transaksi->user_id !== auth()->id()) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        // Only update if currently pending
        if ($transaksi->status === 'pending') {
            $transaksi->update(['status' => 'selesai']);
        }

        return response()->json(['status' => 'success']);
    }

    public function exportPdf(Transaksi $transaksi)
    {
        $transaksi->load(['user', 'details.menu']);
        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksi'))->setPaper('a4', 'portrait');
        return $pdf->download('Nota-' . $transaksi->kode_transaksi . '.pdf');
    }
}
