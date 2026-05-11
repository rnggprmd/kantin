<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = today();

        // Statistik hari ini
        $transaksiHariIni = Transaksi::whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->count();

        $pendapatanHariIni = Transaksi::whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->sum('total_harga');

        $transaksiPending = Transaksi::whereDate('created_at', $today)
            ->where('status', 'pending')
            ->count();

        // Total Menu Aktif
        $totalMenuAktif = Menu::where('is_tersedia', true)->count();

        // Transaksi terbaru
        $transaksiTerbaru = Transaksi::with('user')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        // Grafik penjualan 7 hari terakhir
        $grafikData = Transaksi::select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total_harga) as total'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->where('status', 'selesai')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        // Menu terlaris
        $menuTerlaris = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->where('transaksis.status', 'selesai')
            ->whereDate('transaksis.created_at', '>=', now()->subDays(30))
            ->select('detail_transaksis.nama_menu', DB::raw('SUM(detail_transaksis.qty) as total_terjual'))
            ->groupBy('detail_transaksis.nama_menu')
            ->orderByDesc('total_terjual')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksiPending',
            'totalMenuAktif',
            'transaksiTerbaru',
            'grafikData',
            'menuTerlaris'
        ));
    }
}
