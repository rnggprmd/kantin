@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Keuangan & Penjualan')

@section('content')
<div class="space-y-4">

    {{-- Top Action Bar (Professional Card Style) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-2">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Laporan Keuangan & Penjualan</h2>
                <p class="text-xs text-gray-500 font-medium">Analisis akumulasi pendapatan dan statistik traksi menu secara komprehensif.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('laporan.pdf', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-black rounded-md transition-colors border border-red-200 shadow-sm uppercase tracking-[0.1em]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Simpan PDF
                </a>
                <a href="{{ route('laporan.excel', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-[11px] font-black rounded-md transition-colors border border-green-200 shadow-sm uppercase tracking-[0.1em]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export Excel
                </a>
            </div>
        </div>
        
        {{-- Integrated Filter Bar --}}
        <div class="px-4 py-3 bg-gray-50/50">
            <form method="GET" class="flex flex-col md:flex-row items-end gap-3">
                <div class="flex-1 w-full md:w-auto">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Periode Awal</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <input type="date" name="tanggal_dari" value="{{ $tanggalDari }}"
                               class="w-full bg-white border border-gray-300 text-gray-900 rounded-md pl-9 pr-3 py-1.5 text-sm font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                </div>
                <div class="flex-1 w-full md:w-auto">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Periode Akhir</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <input type="date" name="tanggal_sampai" value="{{ $tanggalSampai }}"
                               class="w-full bg-white border border-gray-300 text-gray-900 rounded-md pl-9 pr-3 py-1.5 text-sm font-medium focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary">
                    </div>
                </div>
                <button type="submit" class="w-full md:w-auto px-6 py-2 bg-gray-900 hover:bg-black text-white text-sm font-black rounded-md transition-all shadow-sm uppercase tracking-widest">
                    Sinkronisasi
                </button>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Penjualan Valid</p>
            <p class="text-2xl font-black text-gray-900 tracking-tighter">{{ $totalTransaksi }} <span class="text-xs font-bold text-gray-400 normal-case tracking-normal ml-0.5">Nota</span></p>
        </div>
        <div class="bg-primary border border-primary rounded-lg p-4 shadow-lg">
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest mb-1.5">Nilai Omzet Bersih</p>
            <p class="text-2xl font-black text-white tracking-tighter">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
        </div>
        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm">
            <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Average Basket Size</p>
            <p class="text-2xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
        </div>
    </div>

    {{-- Grid Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 pb-6">
        
        {{-- Ringkasan Harian --}}
        <div class="lg:col-span-2 bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm flex flex-col">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50/30">
                <h3 class="font-black text-gray-900 text-[11px] uppercase tracking-widest">Jurnal Pendapatan Harian</h3>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-50/80 text-gray-500 text-[11px] font-bold border-b border-gray-200 uppercase tracking-widest">
                        <tr>
                            <th class="px-5 py-4">Tanggal Siklus</th>
                            <th class="px-5 py-4 text-center">Nota</th>
                            <th class="px-5 py-4 text-right">Nilai Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 font-medium">
                        @forelse($ringkasan as $r)
                        <tr class="hover:bg-gray-50/50 text-gray-800 transition-colors">
                            <td class="px-5 py-3.5 text-gray-700 font-bold">{{ \Carbon\Carbon::parse($r->tanggal)->locale('id')->translatedFormat('d F Y') }}</td>
                            <td class="px-5 py-3.5 text-center text-gray-900 font-black tracking-tight">{{ $r->jumlah_transaksi }}</td>
                            <td class="px-5 py-3.5 text-right text-primary font-black tracking-tight">Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-5 py-16 text-center text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-sm font-semibold text-gray-500 mb-1">Data Jurnal Belum Tersedia</p>
                                <p class="text-[11px] font-medium text-gray-400">Silakan pilih rentang tanggal yang berbeda.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Menu Terlaris --}}
        <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm flex flex-col">
            <div class="px-5 py-4 border-b border-gray-200 bg-gray-50/30">
                <h3 class="font-black text-gray-900 text-[11px] uppercase tracking-widest">Peringkat Menu</h3>
            </div>
            <div class="p-5 space-y-4 flex-1 overflow-y-auto">
                @forelse($menuTerlaris as $i => $menu)
                <div class="flex items-center justify-between pb-4 border-b border-gray-100 last:border-0 last:pb-0">
                    <div class="flex items-center gap-3">
                        <span class="w-6 h-6 rounded bg-gray-100 border border-gray-200 flex items-center justify-center text-[10px] font-black shrink-0 text-gray-500">
                            {{ $i + 1 }}
                        </span>
                        <div>
                            <p class="text-[13px] font-bold text-gray-900 leading-tight">{{ $menu->nama_menu }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[10px] font-black bg-gray-50 text-gray-600 px-2 py-0.5 rounded border border-gray-200 uppercase tracking-tighter">{{ $menu->total_terjual }} Unit</p>
                    </div>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center py-12 text-center">
                    <svg class="w-8 h-8 text-gray-200 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                    <p class="text-gray-400 text-[11px] font-semibold">Menu nihil terjual</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
