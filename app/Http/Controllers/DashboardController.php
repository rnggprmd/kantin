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

        // Distribusi Metode Bayar (Hari Ini)
        $distribusiBayar = Transaksi::whereDate('created_at', $today)
            ->where('status', 'selesai')
            ->select('metode_bayar', DB::raw('count(*) as total'))
            ->groupBy('metode_bayar')
            ->get();

        // Performa Kategori (30 hari terakhir)
        $performaKategori = DB::table('detail_transaksis')
            ->join('transaksis', 'detail_transaksis.transaksi_id', '=', 'transaksis.id')
            ->join('menus', 'detail_transaksis.menu_id', '=', 'menus.id')
            ->join('kategoris', 'menus.kategori_id', '=', 'kategoris.id')
            ->where('transaksis.status', 'selesai')
            ->whereDate('transaksis.created_at', '>=', now()->subDays(30))
            ->select('kategoris.nama', DB::raw('SUM(detail_transaksis.subtotal) as total_pendapatan'))
            ->groupBy('kategoris.nama')
            ->orderByDesc('total_pendapatan')
            ->get();

        // Kantin Teraktif (Hari Ini)
        $kantinTeraktif = DB::table('transaksis')
            ->join('users', 'transaksis.user_id', '=', 'users.id')
            ->whereDate('transaksis.created_at', $today)
            ->where('transaksis.status', 'selesai')
            ->select('users.name', DB::raw('count(*) as total_transaksi'))
            ->groupBy('users.name')
            ->orderByDesc('total_transaksi')
            ->limit(5)
            ->get();

        return view('dashboard.index', compact(
            'transaksiHariIni',
            'pendapatanHariIni',
            'transaksiPending',
            'totalMenuAktif',
            'transaksiTerbaru',
            'grafikData',
            'menuTerlaris',
            'distribusiBayar',
            'performaKategori',
            'kantinTeraktif'
        ));
    }
}
