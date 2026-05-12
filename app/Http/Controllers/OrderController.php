<?php

namespace App\Http\Controllers;

use App\Models\Meja;
use App\Models\Menu;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Halaman menu pemesanan untuk siswa (public via QR)
     */
    public function show(string $kode)
    {
        $meja = Meja::where('kode', $kode)->where('is_aktif', true)->firstOrFail();
        $menus = Menu::where('is_tersedia', true)->with('kategori')->orderBy('nama')->get();
        $kategoris = $menus->pluck('kategori')->unique('id')->filter()->values();

        return view('order.menu', compact('meja', 'menus', 'kategoris'));
    }

    /**
     * Proses pesanan dari siswa
     */
    public function store(Request $request, string $kode)
    {
        $meja = Meja::where('kode', $kode)->where('is_aktif', true)->firstOrFail();

        $request->validate([
            'nama_pemesan'       => 'required|string|max:100',
            'metode_bayar'       => 'required|in:tunai,non_tunai',
            'items'              => 'required|array|min:1',
            'items.*.menu_id'    => 'required|exists:menus,id',
            'items.*.qty'        => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $totalHarga = 0;
            $itemsData  = [];

            foreach ($request->items as $item) {
                $menu     = Menu::findOrFail($item['menu_id']);
                $subtotal = $menu->harga * $item['qty'];
                $totalHarga += $subtotal;
                $itemsData[] = [
                    'menu'     => $menu,
                    'qty'      => $item['qty'],
                    'subtotal' => $subtotal,
                ];
            }

            // Nomor antrean: reset per hari
            $nomorAntrean = Transaksi::whereDate('created_at', today())->max('nomor_antrean') + 1;

            $transaksi = Transaksi::create([
                'kode_transaksi'  => Transaksi::generateKode(),
                'user_id'         => null,
                'meja_id'         => $meja->id,
                'nomor_antrean'   => $nomorAntrean,
                'status_pesanan'  => 'menunggu',
                'pelanggan_nama'  => $request->nama_pemesan,
                'total_harga'     => $totalHarga,
                'metode_bayar'    => $request->metode_bayar,
                'status'          => $request->metode_bayar === 'tunai' ? 'pending' : 'pending',
            ]);

            foreach ($itemsData as $d) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'menu_id'      => $d['menu']->id,
                    'nama_menu'    => $d['menu']->nama,
                    'harga_satuan' => $d['menu']->harga,
                    'qty'          => $d['qty'],
                    'subtotal'     => $d['subtotal'],
                ]);
            }

            // Untuk non-tunai: buat Midtrans token
            if ($request->metode_bayar === 'non_tunai') {
                \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                \Midtrans\Config::$isSanitized  = true;
                \Midtrans\Config::$is3ds        = true;

                $params = [
                    'transaction_details' => [
                        'order_id'     => $transaksi->kode_transaksi,
                        'gross_amount' => (int) $totalHarga,
                    ],
                    'customer_details' => [
                        'first_name' => $request->nama_pemesan,
                    ],
                    'callbacks' => [
                        'finish' => route('order.status', $transaksi->kode_transaksi),
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $transaksi->update(['snap_token' => $snapToken]);
            }

            DB::commit();

            if ($request->expectsJson()) {
                return response()->json([
                    'success'      => true,
                    'snap_token'   => $snapToken ?? null,
                    'redirect_url' => route('order.status', $transaksi->kode_transaksi)
                ]);
            }

            return redirect()->route('order.status', $transaksi->kode_transaksi)
                             ->with('success', 'Pesanan berhasil dibuat!');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
            }
            return back()->withErrors(['error' => 'Gagal membuat pesanan: ' . $e->getMessage()]);
        }
    }

    public function status(string $kode)
    {
        $transaksi = Transaksi::with(['details', 'meja'])->where('kode_transaksi', $kode)->firstOrFail();

        // Auto-verify with Midtrans if still pending (especially useful for localhost without webhooks)
        if ($transaksi->metode_bayar === 'non_tunai' && $transaksi->status === 'pending' && $transaksi->snap_token) {
            try {
                \Midtrans\Config::$serverKey    = config('services.midtrans.server_key');
                \Midtrans\Config::$isProduction = config('services.midtrans.is_production');
                $midtransStatus = \Midtrans\Transaction::status($transaksi->kode_transaksi);
                
                if (in_array($midtransStatus->transaction_status, ['settlement', 'capture'])) {
                    $transaksi->update([
                        'status' => 'selesai',
                        'payment_status' => $midtransStatus->transaction_status
                    ]);
                }
            } catch (\Exception $e) {
                // Ignore if check fails (e.g. transaction not found yet)
            }
        }

        return view('order.status', compact('transaksi'));
    }

    /**
     * Kitchen Display System — dashboard pesanan masuk
     */
    public function kitchen()
    {
        $pesanans = Transaksi::with(['details', 'meja'])
            ->whereIn('status_pesanan', ['menunggu', 'diproses'])
            ->whereDate('created_at', today())
            ->orderBy('created_at')
            ->get();

        return view('order.kitchen', compact('pesanans'));
    }

    /**
     * Update status pesanan oleh staf kantin
     */
    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate(['status_pesanan' => 'required|in:menunggu,diproses,siap,selesai']);

        $transaksi->update([
            'status_pesanan' => $request->status_pesanan,
            'status'         => $request->status_pesanan === 'selesai' ? 'selesai' : $transaksi->status,
        ]);

        return response()->json(['success' => true, 'status' => $request->status_pesanan]);
    }
}
