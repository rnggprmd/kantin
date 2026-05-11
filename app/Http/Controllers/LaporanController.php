<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalDari = $request->get('tanggal_dari', today()->startOfMonth()->toDateString());
        $tanggalSampai = $request->get('tanggal_sampai', today()->toDateString());
        $groupBy = $request->get('group_by', 'harian');

        $query = Transaksi::with(['user', 'details'])
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai);

        $transaksis = (clone $query)->orderByDesc('created_at')->get();

        $totalPendapatan = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();
        $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;

        // Ringkasan per hari
        $ringkasan = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total_harga) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderByDesc('tanggal')
            ->get();

        // Menu terlaris dalam range
        $menuTerlaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.status', 'selesai')
            ->whereDate('transaksis.created_at', '>=', $tanggalDari)
            ->whereDate('transaksis.created_at', '<=', $tanggalSampai)
            ->select(
                'detail_transaksis.nama_menu',
                DB::raw('SUM(detail_transaksis.qty) as total_terjual'),
                DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan')
            )
            ->groupBy('detail_transaksis.nama_menu')
            ->orderByDesc('total_terjual')
            ->limit(10)
            ->get();

        // Distribusi Metode Bayar
        $distribusiBayar = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->select('metode_bayar', DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('metode_bayar')
            ->get();

        // Pendapatan per Kategori
        $pendapatanKategori = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('menus', 'detail_transaksis.menu_id', '=', 'menus.id')
            ->join('kategoris', 'menus.kategori_id', '=', 'kategoris.id')
            ->where('transaksis.status', 'selesai')
            ->whereDate('transaksis.created_at', '>=', $tanggalDari)
            ->whereDate('transaksis.created_at', '<=', $tanggalSampai)
            ->select('kategoris.nama', DB::raw('SUM(detail_transaksis.subtotal) as total'))
            ->groupBy('kategoris.nama')
            ->orderByDesc('total')
            ->get();

        // Distribusi Jam Transaksi
        $distribusiJam = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->select(DB::raw('HOUR(created_at) as jam'), DB::raw('COUNT(*) as total'))
            ->groupBy('jam')
            ->orderBy('jam')
            ->get();

        // Pelanggan Teraktif
        $pelangganTeraktif = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->whereNotNull('pelanggan_nama')
            ->select('pelanggan_nama', DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('pelanggan_nama')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        return view('laporan.index', compact(
            'transaksis',
            'ringkasan',
            'menuTerlaris',
            'totalPendapatan',
            'totalTransaksi',
            'rataRata',
            'tanggalDari',
            'tanggalSampai',
            'distribusiBayar',
            'pendapatanKategori',
            'distribusiJam',
            'pelangganTeraktif'
        ));
    }

    public function exportPdf(Request $request)
    {
        $tanggalDari = $request->get('tanggal_dari', today()->startOfMonth()->toDateString());
        $tanggalSampai = $request->get('tanggal_sampai', today()->toDateString());

        $transaksis = Transaksi::with(['user', 'details'])
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->orderByDesc('created_at')
            ->get();

        $totalPendapatan = $transaksis->sum('total_harga');
        $totalTransaksi = $transaksis->count();

        // Data tambahan untuk PDF
        $ringkasan = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->select(DB::raw('DATE(created_at) as tanggal'), DB::raw('COUNT(*) as jumlah'), DB::raw('SUM(total_harga) as total'))
            ->groupBy('tanggal')->orderBy('tanggal')->get();

        $menuTerlaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.status', 'selesai')
            ->whereDate('transaksis.created_at', '>=', $tanggalDari)
            ->whereDate('transaksis.created_at', '<=', $tanggalSampai)
            ->select('detail_transaksis.nama_menu', DB::raw('SUM(detail_transaksis.qty) as total'))
            ->groupBy('detail_transaksis.nama_menu')->orderByDesc('total')->limit(5)->get();

        $distribusiBayar = DB::table('transaksis')
            ->where('status', 'selesai')
            ->whereDate('created_at', '>=', $tanggalDari)
            ->whereDate('created_at', '<=', $tanggalSampai)
            ->select('metode_bayar', DB::raw('COUNT(*) as jumlah'))
            ->groupBy('metode_bayar')->get();

        $pdf = Pdf::loadView('laporan.pdf', compact(
            'transaksis',
            'totalPendapatan',
            'totalTransaksi',
            'tanggalDari',
            'tanggalSampai',
            'ringkasan',
            'menuTerlaris',
            'distribusiBayar'
        ))->setPaper('a4', 'landscape');

        return $pdf->download("laporan-{$tanggalDari}-{$tanggalSampai}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $tanggalDari = $request->get('tanggal_dari', today()->startOfMonth()->toDateString());
        $tanggalSampai = $request->get('tanggal_sampai', today()->toDateString());

        return Excel::download(
            new LaporanExport($tanggalDari, $tanggalSampai),
            "laporan-{$tanggalDari}-{$tanggalSampai}.xlsx"
        );
    }
}
