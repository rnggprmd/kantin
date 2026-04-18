@extends('layouts.app')
@section('title', 'Inventaris')
@section('page-title', 'Inventaris Material')

@section('content')
<div class="h-full flex flex-col space-y-4">

    {{-- Top Action Bar (Professional Card Style) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-2">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Inventaris</h2>
                <p class="text-xs text-gray-500 font-medium">Pengawasan stok bahan baku & penunjang operasional.</p>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('inventaris.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-[#0c0d24] text-white text-sm font-semibold rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Item
            </a>
            @else
            <div class="hidden md:block">
                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest border border-gray-200 px-3 py-1.5 rounded-md bg-gray-50">View Only Mode</span>
            </div>
            @endif
        </div>
        
        {{-- Integrated Filter Bar with Auto-Submit --}}
        <div class="px-4 py-3 bg-gray-50/50">
            <form method="GET" x-data x-ref="inventarisForm" class="flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Input --}}
                <div class="flex-1 relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           @input.debounce.500ms="$refs.inventarisForm.submit()"
                           placeholder="Cari aset atau bahan berdasarkan nama..."
                           class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>

                {{-- Status Filter --}}
                <div class="w-full sm:w-56">
                    <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Kondisi Stok</option>
                        <option value="rendah" {{ request('status') === 'rendah' ? 'selected' : '' }}>Stok Menipis (Kritis)</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request('search') || request('status'))
                <a href="{{ route('inventaris.index') }}" class="w-full sm:w-auto px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-md hover:bg-gray-200 transition-colors border border-gray-200 text-center shadow-sm">
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
                        <th class="px-5 py-4">Nama Aset/Bahan</th>
                        <th class="px-5 py-4 text-right">Harga Beli</th>
                        <th class="px-5 py-4 text-right">Kuantitas Stok</th>
                        <th class="px-5 py-4 text-center">Status</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-5 py-4 text-right w-32">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    @forelse($inventaris as $item)
                    <tr class="hover:bg-gray-50/50 transition-colors {{ $item->isStokRendah() ? 'bg-red-50/10' : '' }}">
                        <td class="px-5 py-3.5 text-center text-gray-500 font-semibold">
                            {{ ($inventaris->currentPage() - 1) * $inventaris->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="font-bold text-gray-900 text-[13px]">{{ $item->nama }}</p>
                            <p class="text-[11px] text-gray-500 mt-0.5 line-clamp-1 max-w-[250px] font-normal" title="{{ $item->supplier ?: 'Supplier Internal' }}">Hulu: {{ $item->supplier ?: '-' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <p class="text-gray-900 font-bold tracking-tight">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</p>
                            <p class="text-[10px] text-gray-400 font-normal uppercase tracking-tight">Per {{ $item->satuan }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <p class="font-bold text-sm tracking-tight {{ $item->isStokRendah() ? 'text-red-600' : 'text-gray-900' }}">
                                {{ number_format($item->stok, 0, ',', '.') }} <span class="text-xs text-gray-500 font-normal">{{ $item->satuan }}</span>
                            </p>
                            <p class="text-[10px] text-gray-400 mt-0.5 font-normal">Batas Aman: {{ number_format($item->stok_minimum, 0, ',', '.') }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($item->isStokRendah())
                            <span class="text-red-600 font-black text-[11px] uppercase tracking-wider">Kritis</span>
                            @else
                            <span class="text-green-600 font-black text-[11px] uppercase tracking-wider">Aman</span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('inventaris.edit', $item->id) }}"
                                   class="p-1.5 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-md transition-all" title="Ubah Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <button type="button" 
                                        @click="$dispatch('confirm', { 
                                            title: 'Hapus Aset?', 
                                            message: 'Apakah Anda yakin ingin menghapus aset {{ $item->nama }}? Tindakan ini tidak bisa dibatalkan.', 
                                            action: '{{ route('inventaris.destroy', $item->id) }}',
                                            method: 'DELETE'
                                        })"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ auth()->user()->isAdmin() ? 6 : 5 }}" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                            <p class="text-sm font-semibold text-gray-500 mb-1">Gudang Inventaris Kosong</p>
                            <p class="text-[11px] font-medium text-gray-400">Belum ada aset atau bahan baku yang terdata di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($inventaris->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 bg-white">
            {{ $inventaris->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
