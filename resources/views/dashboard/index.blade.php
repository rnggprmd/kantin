@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Overview Kinerja')

@section('content')
<div class="space-y-6">

    @if(auth()->user()->isAdmin())
    
    {{-- Header Section (Flat SaaS Style) --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-3 pb-2 border-b border-gray-200">
        <div>
            <h2 class="text-xl font-bold text-gray-900 tracking-tight">Ringkasan Operasional</h2>
            <p class="text-sm text-gray-500 font-medium">Data performa sistem pada hari ini ({{ now()->translatedFormat('d F Y') }}).</p>
        </div>
        <div class="shrink-0 flex items-center bg-white border border-gray-300 rounded-md px-3 py-1.5 shadow-sm text-sm font-semibold text-gray-700">
            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Hari Ini
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Pendapatan Hari Ini --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Pendapatan Kotor</p>
                <div class="p-1.5 bg-gray-50 rounded-md text-gray-400 border border-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-gray-900 tracking-tight">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        </div>

        {{-- Transaksi Hari Ini --}}
        <div class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm">
            <div class="flex justify-between items-start mb-3">
                <p class="text-xs text-gray-500 uppercase tracking-wider font-bold">Total Transaksi</p>
                <div class="p-1.5 bg-gray-50 rounded-md text-gray-400 border border-gray-100">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black text-gray-900 tracking-tight">{{ $transaksiHariIni }} <span class="text-sm font-semibold text-gray-400 normal-case tracking-normal">nota</span></p>
        </div>

        {{-- Transaksi Pending --}}
        <a href="{{ route('transaksi.index', ['status' => 'pending']) }}" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:border-amber-300 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-3">
                <p class="text-[11px] text-amber-600 uppercase tracking-wider font-bold">Tagihan Belum Lunas</p>
                <div class="p-1.5 bg-amber-50 rounded-md text-amber-500 border border-amber-100 group-hover:bg-amber-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black {{ $transaksiPending > 0 ? 'text-amber-600' : 'text-gray-900' }} tracking-tight">{{ $transaksiPending }} <span class="text-sm font-semibold text-amber-500/70 normal-case tracking-normal">nota</span></p>
        </a>

        {{-- Peringatan Stok --}}
        <a href="{{ route('inventaris.index', ['filter' => 'rendah']) }}" class="bg-white border border-gray-200 rounded-xl p-5 shadow-sm hover:border-red-300 hover:shadow-md transition-all group">
            <div class="flex justify-between items-start mb-3">
                <p class="text-[11px] text-red-600 uppercase tracking-wider font-bold">Peringatan Stok Kritis</p>
                <div class="p-1.5 bg-red-50 rounded-md text-red-500 border border-red-100 group-hover:bg-red-100 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-black {{ ($stokMenuRendah + $stokInventarisRendah) > 0 ? 'text-red-600' : 'text-gray-900' }} tracking-tight">
                {{ $stokMenuRendah }} <span class="text-xs font-semibold text-red-400 normal-case tracking-normal">Menu</span> &amp; {{ $stokInventarisRendah }} <span class="text-xs font-semibold text-red-400 normal-case tracking-normal">Alat</span>
            </p>
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        {{-- Transaksi Terakhir --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-bold text-gray-900 text-sm">Aktivitas Transaksi</h3>
                    <p class="text-xs text-gray-500">10 log transaksi terakhir</p>
                </div>
                <a href="{{ route('transaksi.index') }}" class="text-xs font-bold text-gray-600 bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-md hover:bg-gray-100 transition-colors">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50 text-gray-500 text-[11px] uppercase tracking-wider font-bold border-b border-gray-200">
                        <tr>
                            <th class="px-5 py-3">Waktu</th>
                            <th class="px-5 py-3">Kode</th>
                            <th class="px-5 py-3">Kasir</th>
                            <th class="px-5 py-3 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium">
                        @forelse($transaksiTerbaru as $t)
                        <tr class="hover:bg-gray-50 text-gray-800 transition-colors">
                            <td class="px-5 py-3 text-gray-500 text-xs">{{ $t->created_at->format('H:i') }}</td>
                            <td class="px-5 py-3 font-mono text-[11px] text-gray-600 tracking-tight">{{ $t->kode_transaksi }}</td>
                            <td class="px-5 py-3">{{ $t->user?->name ?? 'Sistem' }}</td>
                            <td class="px-5 py-3 text-right text-gray-900 font-bold tracking-tight">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-5 py-8 text-center text-gray-400">Belum ada transaksi tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Menu Terlaris (30 Hari) --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col">
            <div class="px-5 py-4 border-b border-gray-100">
                <h3 class="font-bold text-gray-900 text-sm">Produk Performa Tinggi</h3>
                <p class="text-xs text-gray-500">Menu paling diminati (30 Hari Terakhir)</p>
            </div>
            <div class="p-5 space-y-4 flex-1">
                @forelse($menuTerlaris as $i => $menu)
                <div class="flex justify-between items-center group">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded border border-gray-200 bg-gray-50 flex items-center justify-center text-gray-400 font-bold text-[10px] group-hover:bg-primary group-hover:text-white group-hover:border-primary transition-colors">
                            #{{ $i + 1 }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 leading-tight">{{ $menu->nama_menu }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2 py-1 rounded bg-green-50 text-green-700 text-xs font-bold ring-1 ring-inset ring-green-600/20">
                            {{ $menu->total_terjual }} porsi
                        </span>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full text-center py-8">
                    <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    <p class="text-sm font-semibold text-gray-500">Belum ada kompilasi data penjualan.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
