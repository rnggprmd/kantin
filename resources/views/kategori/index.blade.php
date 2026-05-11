@extends('layouts.app')
@section('title', 'Manajemen Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div class="h-full flex flex-col space-y-4">

    {{-- Top Action Bar --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-4">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Kategori Menu</h2>
                <p class="text-xs text-gray-500 font-medium">Pengelompokan jenis menu makanan & minuman.</p>
            </div>
            <a href="{{ route('kategori.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-[#0c0d24] text-white text-sm font-semibold rounded-md shadow-sm transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Kategori
            </a>
        </div>
        <div class="px-4 py-3 bg-gray-50/50">
            <form method="GET" x-data x-ref="filterForm" class="flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Input --}}
                <div class="flex-1 relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari kategori berdasarkan nama atau deskripsi..."
                           class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>

                {{-- Status Filter --}}
                <div class="w-full sm:w-48">
                    <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Status Data</option>
                        <option value="digunakan" {{ request('status') === 'digunakan' ? 'selected' : '' }}>Digunakan (Aktif)</option>
                        <option value="kosong" {{ request('status') === 'kosong' ? 'selected' : '' }}>Kosong (Belum Dipakai)</option>
                    </select>
                </div>

                {{-- Reset Button (Only shows when filtered) --}}
                @if(request('search') || request('status'))
                <div class="flex items-center gap-2 w-full sm:w-auto">
                    <a href="{{ route('kategori.index') }}" class="w-full sm:w-auto px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-md hover:bg-gray-200 transition-colors border border-gray-200 text-center shadow-sm" title="Reset Filter">
                        Hapus Filter
                    </a>
                </div>
                @endif
            </form>
        </div>
    </div>

    {{-- Flash Message --}}
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md text-sm font-medium flex items-center justify-between shadow-sm">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
        <button @click="show = false" class="text-green-500 hover:text-green-700">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    @endif
    @if($errors->any())
    <div x-data="{ show: true }" x-show="show" class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md text-sm font-medium flex-col gap-1 shadow-sm">
        @foreach($errors->all() as $error)
            <div class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ $error }}
            </div>
        @endforeach
    </div>
    @endif

    {{-- Table Container --}}
    <div class="bg-white border border-gray-200 rounded-lg flex-1 overflow-hidden shadow-sm">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/80 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-4 w-12 text-center">No</th>
                        <th class="px-5 py-4">Nama Kategori</th>
                        <th class="px-5 py-4 w-1/3">Deskripsi Singkat</th>
                        <th class="px-5 py-4 text-center">Total Menu Terkait</th>
                        <th class="px-5 py-4 text-right">Tindakan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    @forelse($kategoris as $k)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3.5 text-center text-gray-500 font-semibold">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3.5">
                            <p class="text-[13px] font-bold text-gray-900">{{ $k->nama }}</p>
                            <p class="text-[11px] text-gray-400 font-mono mt-0.5">slug: {{ $k->slug }}</p>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-xs text-gray-600 line-clamp-2 leading-relaxed" title="{{ $k->deskripsi }}">{{ $k->deskripsi ?? '-' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($k->menus_count > 0)
                                <span class="text-[13px] font-extrabold text-gray-900">{{ $k->menus_count }} <span class="text-[10px] text-gray-500 font-bold uppercase tracking-wide">Item</span></span>
                            @else
                                <span class="text-[11px] font-black text-amber-600 uppercase tracking-wider">Kosong</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-right w-32">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('kategori.edit', $k->id) }}" class="p-1.5 text-gray-500 hover:text-primary transition-colors hover:bg-gray-100 rounded-md" title="Ubah Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($k->menus_count === 0)
                                <button type="button" 
                                        @click="$dispatch('confirm', { 
                                            title: 'Hapus Kategori?', 
                                            message: 'Apakah Anda yakin ingin menghapus kategori {{ $k->nama }}? Seluruh kaitan menu harus kosong terlebih dahulu.', 
                                            action: '{{ route('kategori.destroy', $k->id) }}',
                                            method: 'DELETE'
                                        })"
                                        class="p-1.5 text-gray-500 hover:text-red-600 transition-colors hover:bg-red-50 rounded-md" title="Hapus Data">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @else
                                <button type="button" disabled class="p-1.5 text-gray-300 cursor-not-allowed" title="Kategori ini sedang digunakan dan tidak bisa dihapus">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                            <p class="text-sm font-semibold text-gray-500 mb-1">Belum ada Kategori terdaftar</p>
                            <p class="text-[11px] font-medium text-gray-400 max-w-sm mx-auto">Klik tombol 'Tambah Kategori' di atas untuk mulai membuat struktur katalog menu Anda.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
