@extends('layouts.app')
@section('title', 'Menu')
@section('page-title', 'Katalog Menu Kantin')

@section('content')
<div class="space-y-4">

    {{-- Top Action & Filter Bar (SaaS Flat Style) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Katalog Menu</h2>
                <p class="text-xs text-gray-500 font-medium">Manajemen penawaran makanan dan minuman.</p>
            </div>
            <a href="{{ route('menu.create') }}"
               class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-[#0c0d24] text-white text-sm font-semibold rounded-md shadow-sm transition-colors focus:ring-2 focus:ring-offset-1 focus:ring-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Registrasi Menu
            </a>
        </div>
        <div class="p-3 bg-gray-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3 items-center">
                <div class="flex-1 relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari penamaan menu..."
                           class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>
                <div class="w-full sm:w-48 shrink-0">
                    <select name="kategori_id" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-48 shrink-0">
                    <select name="status" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Status Stok</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Stok Tersedia</option>
                        <option value="rendah" {{ request('status') === 'rendah' ? 'selected' : '' }}>Stok Menipis (<= 5)</option>
                        <option value="habis" {{ request('status') === 'habis' ? 'selected' : '' }}>Out of Stock</option>
                    </select>
                </div>
            </form>
        </div>
    </div>

    {{-- Menu Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3">
        @forelse($menus as $menu)
        <div class="bg-white border border-gray-200 hover:border-gray-300 rounded-xl flex flex-col overflow-hidden shadow-sm hover:shadow transition-all group relative">
            
            {{-- Status Badge (Absolute) --}}
            <div class="absolute top-2 right-2 z-10 flex flex-col gap-1 items-end pointer-events-none">
                @if(!$menu->is_tersedia || $menu->stok == 0)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-sm bg-red-600/90 text-white uppercase tracking-wider ring-1 ring-red-700/50">Habis</span>
                @elseif($menu->stok <= 5)
                <span class="text-[10px] font-bold px-2 py-0.5 rounded backdrop-blur-sm bg-amber-500/90 text-white uppercase tracking-wider ring-1 ring-amber-600/50">Limit: {{ $menu->stok }}</span>
                @endif
            </div>

            <div class="aspect-square bg-gray-50 relative overflow-hidden shrink-0 border-b border-gray-100">
                @if($menu->gambar)
                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center">
                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                @endif
            </div>
            
            <div class="p-3 flex flex-col flex-1">
                <div>
                    <h3 class="text-sm font-bold text-gray-900 leading-tight line-clamp-1" title="{{ $menu->nama }}">{{ $menu->nama }}</h3>
                    <p class="text-[10px] text-gray-500 font-bold uppercase tracking-wider mt-0.5">{{ $menu->kategori?->nama }}</p>
                </div>
                <div class="mt-auto pt-2">
                    <p class="text-[13px] text-gray-900 font-extrabold tracking-tight">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between mt-2 pt-2 border-t border-dashed border-gray-200">
                        <span class="text-[11px] text-gray-500 font-bold bg-gray-50 px-1.5 py-0.5 border border-gray-100 rounded">Stok: {{ $menu->stok }}</span>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('menu.edit', $menu->id) }}" class="p-1 hover:bg-gray-100 text-gray-500 hover:text-gray-900 rounded transition-colors" title="Modifikasi">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </a>
                            <button type="button" 
                                    @click="$dispatch('confirm', { 
                                        title: 'Hapus Menu?', 
                                        message: 'Apakah Anda yakin ingin menghapus permenen menu {{ $menu->nama }}? Tindakan ini tidak bisa dibatalkan.', 
                                        action: '{{ route('menu.destroy', $menu->id) }}',
                                        method: 'DELETE'
                                    })"
                                    class="p-1 hover:bg-red-50 text-red-500 hover:text-red-700 rounded transition-colors" title="Hapus">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 bg-white border border-gray-200 rounded-lg text-center shadow-sm flex flex-col items-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-3 border border-gray-100">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <p class="font-bold text-gray-900 mb-1">Katalog Masih Kosong</p>
            <p class="text-sm text-gray-500">Silakan mulailah dengan menambahkan menu pertama Anda.</p>
        </div>
        @endforelse
    </div>

    @if($menus->hasPages())
    <div class="bg-white border border-gray-200 rounded-lg px-4 py-3 shadow-sm">
        {{ $menus->links() }}
    </div>
    @endif
</div>
@endsection
