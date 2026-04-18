@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="h-full flex flex-col space-y-4">

    {{-- Top Action Bar (Professional Card Style) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-2">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Riwayat Transaksi</h2>
                <p class="text-xs text-gray-500 font-medium">Pantau rekam jejak pesanan dan pemasukan kantin secara real-time.</p>
            </div>
            <a href="{{ route('transaksi.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-[#0c0d24] text-white text-sm font-semibold rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                POS Kasir Baru
            </a>
        </div>
        
        {{-- Integrated Filter Bar with Auto-Submit --}}
        <div class="px-4 py-3 bg-gray-50/50">
            <form method="GET" x-data x-ref="transaksiForm" class="flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Input --}}
                <div class="flex-1 relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           @input.debounce.500ms="$refs.transaksiForm.submit()"
                           placeholder="Cari kode nota atau nama pelanggan..."
                           class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>

                {{-- Status Filter --}}
                <div class="w-full sm:w-56">
                    <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Status Data</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Tuntas (Lunas)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Verifikasi)</option>
                        <option value="batal" {{ request('status') === 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request('search') || request('status'))
                <a href="{{ route('transaksi.index') }}" class="w-full sm:w-auto px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-md hover:bg-gray-200 transition-colors border border-gray-200 text-center shadow-sm">
                    Hapus Filter
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white border border-gray-200 rounded-lg flex-1 overflow-hidden shadow-sm">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/80 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-4 w-12 text-center">No</th>
                        <th class="px-5 py-4">Data Nota</th>
                        <th class="px-5 py-4">Waktu Terbit</th>
                        <th class="px-5 py-4 text-center">Jalur Bayar</th>
                        <th class="px-5 py-4 text-right">Nilai Total</th>
                        <th class="px-5 py-4 text-center">Status Akhir</th>
                        <th class="px-5 py-4 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-gray-50/50 transition-colors text-gray-800">
                        <td class="px-5 py-3.5 text-center text-gray-500 font-semibold">
                            {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-mono text-[13px] font-bold text-gray-900 tracking-tight">{{ $t->kode_transaksi }}</p>
                            @if($t->pelanggan_nama)
                            <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-1 max-w-[150px] font-normal" title="{{ $t->pelanggan_nama }}">A/N: {{ $t->pelanggan_nama }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-[13px] font-bold text-gray-900">{{ $t->created_at->format('d M Y') }}</p>
                            <p class="text-[11px] text-gray-400 font-normal">Pukul {{ $t->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="text-[10px] font-bold uppercase text-gray-600 tracking-wide">
                                {{ str_replace('_', ' ', $t->metode_bayar) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <p class="text-[14px] font-black tracking-tight text-gray-900">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($t->status === 'selesai')
                                <span class="text-green-600 font-black text-[11px] uppercase tracking-wider">Tuntas</span>
                            @elseif($t->status === 'pending')
                                <span class="text-yellow-600 font-black text-[11px] uppercase tracking-wider">Tertunda</span>
                            @else
                                <span class="text-red-500 font-black text-[11px] uppercase tracking-wider">Batal</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('transaksi.show', $t->id) }}"
                                   class="p-1.5 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-md transition-all" title="Lihat Struk">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                @if(auth()->user()->isAdmin() && $t->status !== 'batal')
                                <button type="button" 
                                        @click="$dispatch('confirm', { 
                                            title: 'Batalkan Nota?', 
                                            message: 'Apakah Anda yakin ingin membatalkan transaksi {{ $t->kode_transaksi }}? Stok barang akan otomatis dikembalikan ke gudang.', 
                                            action: '{{ route('transaksi.destroy', $t->id) }}',
                                            method: 'DELETE',
                                            confirmText: 'Ya, Batalkan Nota'
                                        })"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all" title="Batalkan Transaksi">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                            <p class="text-sm font-semibold text-gray-500 mb-1">Riwayat Transaksi Kosong</p>
                            <p class="text-[11px] font-medium text-gray-400">Belum ada nota yang terbit di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($transaksis->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 bg-white">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
