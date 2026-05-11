@extends('layouts.app')
@section('title', 'Laporan')
@section('page-title', 'Keuangan & Penjualan')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #15173D, #2d1b69);">
                    <span class="material-symbols-outlined text-white !text-[22px]">analytics</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Laporan Keuangan</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Analisis akumulasi pendapatan dan statistik traksi menu.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('laporan.pdf', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-700 text-[11px] font-black rounded-xl transition-all border border-red-100 uppercase tracking-wider">
                    <span class="material-symbols-outlined !text-[18px]">picture_as_pdf</span>
                    Simpan PDF
                </a>
                <a href="{{ route('laporan.excel', request()->all()) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-50 hover:bg-green-100 text-green-700 text-[11px] font-black rounded-xl transition-all border border-green-100 uppercase tracking-wider">
                    <span class="material-symbols-outlined !text-[18px]">table_view</span>
                    Export Excel
                </a>
            </div>
        </div>
        
        {{-- Filter Bar --}}
        <div class="px-5 py-4 bg-gray-50/50">
            <form method="GET" class="flex flex-col md:flex-row items-end gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Periode Awal</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">calendar_today</span>
                        <input type="date" name="tanggal_dari" value="{{ $tanggalDari }}"
                               class="w-full bg-white border border-gray-200 text-gray-900 rounded-xl pl-10 pr-3 py-2 text-sm font-bold focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-1.5 ml-1">Periode Akhir</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">event</span>
                        <input type="date" name="tanggal_sampai" value="{{ $tanggalSampai }}"
                               class="w-full bg-white border border-gray-200 text-gray-900 rounded-xl pl-10 pr-3 py-2 text-sm font-bold focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                    </div>
                </div>
                <button type="submit" class="w-full md:w-auto px-6 py-2.5 bg-primary text-white text-xs font-black rounded-xl hover:bg-[#0c0d24] transition-all shadow-md active:scale-95 uppercase tracking-widest">
                    Sinkronisasi Data
                </button>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Penjualan Valid</p>
                <p class="text-3xl font-black text-gray-900 tracking-tighter">{{ $totalTransaksi }} <span class="text-xs font-bold text-gray-400 normal-case tracking-normal ml-0.5">Nota</span></p>
            </div>
        </div>
        <div class="rounded-2xl p-5 shadow-lg relative overflow-hidden group" style="background: linear-gradient(135deg, #15173D, #2d1b69);">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-white/5 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-white/50 uppercase tracking-widest mb-2">Nilai Omzet Bersih</p>
                <p class="text-3xl font-black text-white tracking-tighter">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white border border-gray-100 rounded-2xl p-5 shadow-sm relative overflow-hidden group">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 bg-gray-50 rounded-full group-hover:scale-110 transition-transform duration-500"></div>
            <div class="relative z-10">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Average Basket Size</p>
                <p class="text-3xl font-black text-gray-900 tracking-tighter">Rp {{ number_format($rataRata, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Detailed Panels --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Daily Journal --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                <h3 class="font-black text-gray-900 text-[11px] uppercase tracking-widest">Jurnal Pendapatan Harian</h3>
                <span class="material-symbols-outlined text-gray-300 !text-[20px]">calendar_view_day</span>
            </div>
            <div class="overflow-x-auto w-full">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-6 py-4 text-[10px] text-gray-400 font-black uppercase tracking-widest">Tanggal Siklus</th>
                            <th class="px-6 py-4 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center">Nota</th>
                            <th class="px-6 py-4 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right">Nilai Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50 font-medium">
                        @forelse($ringkasan as $r)
                        <tr class="hover:bg-violet-50/20 transition-colors">
                            <td class="px-6 py-4 text-gray-700 font-bold">
                                {{ \Carbon\Carbon::parse($r->tanggal)->locale('id')->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-100 text-gray-600 text-[11px] font-black px-2 py-0.5 rounded-lg border border-gray-200">
                                    {{ $r->jumlah_transaksi }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <span class="text-primary font-black tracking-tight">Rp {{ number_format($r->total_pendapatan, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-16 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <span class="material-symbols-outlined text-gray-200 !text-[48px]">no_sim</span>
                                    <p class="font-black text-gray-400">Data Jurnal Belum Tersedia</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Top Selling Items --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50/30">
                <h3 class="font-black text-gray-900 text-[11px] uppercase tracking-widest">Peringkat Menu</h3>
                <span class="material-symbols-outlined text-gray-300 !text-[20px]">emoji_events</span>
            </div>
            <div class="p-6 space-y-4 flex-1">
                @forelse($menuTerlaris as $i => $menu)
                <div class="flex items-center justify-between pb-3 border-b border-gray-50 last:border-0 last:pb-0 group">
                    <div class="flex items-center gap-3 min-w-0">
                        <span class="w-7 h-7 rounded-lg bg-primary/5 text-primary text-[10px] font-black flex items-center justify-center shrink-0 border border-primary/10 group-hover:bg-primary group-hover:text-white transition-colors">
                            {{ $i + 1 }}
                        </span>
                        <p class="text-[13px] font-black text-gray-800 leading-tight truncate">{{ $menu->nama_menu }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <p class="text-[10px] font-black bg-secondary/5 text-secondary px-2 py-0.5 rounded-lg border border-secondary/10 uppercase tracking-tighter">{{ $menu->total_terjual }} Unit</p>
                    </div>
                </div>
                @empty
                <div class="h-full flex flex-col items-center justify-center py-12 text-center">
                    <span class="material-symbols-outlined text-gray-200 !text-[32px]">inventory_2</span>
                    <p class="text-gray-400 text-[11px] font-black uppercase mt-2 tracking-widest">Kosong</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
