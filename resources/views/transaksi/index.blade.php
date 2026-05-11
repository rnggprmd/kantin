@extends('layouts.app')
@section('title', 'Riwayat Transaksi')
@section('page-title', 'Riwayat Transaksi')

@section('content')
<div class="space-y-5">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #15173D, #2d1b69);">
                    <span class="material-symbols-outlined text-white !text-[22px]">receipt_long</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Riwayat Transaksi</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Rekam jejak pesanan dan pemasukan kantin secara real-time.</p>
                </div>
            </div>

        </div>
        
        {{-- Filter Bar --}}
        <div class="px-5 py-3.5 bg-gray-50/50">
            <form method="GET" x-data x-ref="transaksiForm" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex-1 relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           @input.debounce.500ms="$refs.transaksiForm.submit()"
                           placeholder="Cari kode nota atau nama pelanggan..."
                           class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-xl pl-10 pr-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                </div>
                <div class="w-full sm:w-52">
                    <select name="status" class="w-full bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="selesai" {{ request('status') === 'selesai' ? 'selected' : '' }}>Tuntas (Lunas)</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Tertunda (Verifikasi)</option>
                        <option value="batal" {{ request('status') === 'batal' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                </div>
                @if(request('search') || request('status'))
                <a href="{{ route('transaksi.index') }}"
                   class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-600 text-xs font-black rounded-xl hover:bg-gray-200 transition-colors border border-gray-200 text-center flex items-center gap-1.5 justify-center">
                    <span class="material-symbols-outlined !text-[16px]">filter_alt_off</span> Hapus Filter
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr style="background: linear-gradient(90deg, #f8f5ff, #f0f2f8);">
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center w-12">No</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Data Nota</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Waktu</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center">Metode Bayar</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right">Total</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center">Status</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($transaksis as $t)
                    <tr class="hover:bg-violet-50/30 transition-colors group">
                        <td class="px-5 py-3.5 text-center text-xs text-gray-400 font-bold">
                            {{ ($transaksis->currentPage() - 1) * $transaksis->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5">
                            <code class="text-[12px] font-black text-primary bg-primary/5 px-2 py-0.5 rounded-lg">{{ $t->kode_transaksi }}</code>
                            @if($t->pelanggan_nama)
                            <p class="text-[11px] text-gray-400 mt-1 font-medium">A/N: {{ $t->pelanggan_nama }}</p>
                            @endif
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-sm font-bold text-gray-800">{{ $t->created_at->format('d M Y') }}</p>
                            <p class="text-[11px] text-gray-400 font-medium mt-0.5">{{ $t->created_at->format('H:i') }} WIB</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide
                                {{ $t->metode_bayar === 'tunai' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-blue-50 text-blue-700 border border-blue-100' }}">
                                <span class="material-symbols-outlined !text-[13px]">{{ $t->metode_bayar === 'tunai' ? 'payments' : 'credit_card' }}</span>
                                {{ str_replace('_', ' ', $t->metode_bayar) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <p class="text-sm font-black text-gray-900 tracking-tight">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($t->status === 'selesai')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 text-[10px] font-black uppercase tracking-wide rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Tuntas
                                </span>
                            @elseif($t->status === 'pending')
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-700 text-[10px] font-black uppercase tracking-wide rounded-full border border-amber-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500 inline-block animate-pulse"></span> Tertunda
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 text-[10px] font-black uppercase tracking-wide rounded-full border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Batal
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('transaksi.show', $t->id) }}"
                                   class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Lihat Struk">
                                    <span class="material-symbols-outlined !text-[18px]">visibility</span>
                                </a>
                                @if(auth()->user()->isAdmin() && $t->status !== 'batal')
                                <button type="button"
                                        @click="$dispatch('confirm', {
                                            title: 'Batalkan Nota?',
                                            message: 'Apakah Anda yakin ingin membatalkan transaksi {{ $t->kode_transaksi }}?',
                                            action: '{{ route('transaksi.destroy', $t->id) }}',
                                            method: 'DELETE',
                                            confirmText: 'Ya, Batalkan'
                                        })"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Batalkan">
                                    <span class="material-symbols-outlined !text-[18px]">cancel</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-gray-200 !text-[48px]">receipt_long</span>
                                <p class="font-black text-gray-400">Riwayat Transaksi Kosong</p>
                                <p class="text-xs text-gray-300">Belum ada nota yang terbit di sistem.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($transaksis->hasPages())
        <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50/30">
            {{ $transaksis->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
