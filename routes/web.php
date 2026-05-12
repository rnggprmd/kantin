<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Root redirect
Route::get('/', fn() => redirect()->route('dashboard'));

// Midtrans Callback (Public)
Route::post('/midtrans/callback', [\App\Http\Controllers\MidtransController::class, 'callback'])->name('midtrans.callback');

// Pemesanan Siswa via QR (Public — no login required)
Route::get('/order/status/{kode}', [\App\Http\Controllers\OrderController::class, 'status'])->name('order.status');
Route::get('/order/{kode}', [\App\Http\Controllers\OrderController::class, 'show'])->name('order.show');
Route::post('/order/{kode}', [\App\Http\Controllers\OrderController::class, 'store'])->name('order.store');

// Authenticated routes — Kasir & Admin
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile (Self Service)
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Transaksi
    Route::get('/transaksi', [TransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/create', [TransaksiController::class, 'create'])->name('transaksi.create');
    Route::post('/transaksi', [TransaksiController::class, 'store'])->name('transaksi.store');
    Route::get('/transaksi/{transaksi}', [TransaksiController::class, 'show'])->name('transaksi.show');
    Route::get('/transaksi/{transaksi}/pdf', [TransaksiController::class, 'exportPdf'])->name('transaksi.pdf');
    Route::post('/transaksi/{transaksi}/success', [TransaksiController::class, 'markAsSuccess'])->name('transaksi.mark-as-success');

    // Kitchen Display System (Staf Kantin)
    Route::get('/kitchen', [\App\Http\Controllers\OrderController::class, 'kitchen'])->name('kitchen.index');
    Route::post('/kitchen/{transaksi}/status', [\App\Http\Controllers\OrderController::class, 'updateStatus'])->name('kitchen.update-status');


    // Admin-only: Batalkan transaksi
    Route::delete('/transaksi/{transaksi}', [TransaksiController::class, 'destroy'])
        ->name('transaksi.destroy')
        ->middleware('role:admin');

    // Menu & Kategori (Read-access for all, Write-access for admin)

    Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

    // Admin-only routes
    Route::middleware('role:admin')->group(function () {
        // Menu & Kategori Management
        Route::resource('kategori', KategoriController::class)->except(['show']);
        Route::resource('menu', MenuController::class)->except(['index']);

        // Laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/export/pdf', [LaporanController::class, 'exportPdf'])->name('laporan.pdf');
        Route::get('/laporan/export/excel', [LaporanController::class, 'exportExcel'])->name('laporan.excel');

        // Meja / Lokasi
        Route::resource('meja', \App\Http\Controllers\MejaController::class)->except(['show', 'create', 'edit']);

        // Pengguna
        Route::resource('pengguna', PenggunaController::class)->except(['show']);
    });
});
