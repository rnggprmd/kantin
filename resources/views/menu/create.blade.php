@extends('layouts.app')
@section('title', 'Menu Baru')
@section('page-title', 'Registrasi Menu Baru')

@section('content')
<div class="max-w-5xl mx-auto" x-data="{ 
    preview: null, 
    isTersedia: {{ old('is_tersedia', 'true') === 'true' || old('is_tersedia') === '1' ? 'true' : 'false' }} 
}">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #982598, #E491C9);">
                <span class="material-symbols-outlined text-white !text-[24px]">add_business</span>
            </div>
            <div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Menu</h2>
                <p class="text-xs text-gray-400 font-medium mt-1">Registrasi item makanan atau minuman baru ke sistem.</p>
            </div>
        </div>
        <a href="{{ route('menu.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-white text-gray-500 text-xs font-black rounded-2xl border border-gray-100 shadow-sm hover:bg-gray-50 hover:text-gray-900 transition-all uppercase tracking-widest">
            <span class="material-symbols-outlined !text-[18px]">arrow_back</span>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Section 1: Visual & Basic Info --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1 space-y-4">
                <div class="bg-white rounded-3xl p-2 shadow-sm border border-gray-100 overflow-hidden relative group">
                    <div class="aspect-square bg-gray-50 rounded-2xl flex flex-col items-center justify-center border-2 border-dashed border-gray-200 group-hover:border-secondary transition-all relative overflow-hidden">
                        <input type="file" name="gambar" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null">
                        
                        <div class="text-center p-6" x-show="!preview">
                            <span class="material-symbols-outlined text-gray-300 !text-[48px] mb-3 group-hover:scale-110 transition-transform">image</span>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-widest">Unggah Foto</p>
                        </div>

                        <img :src="preview" x-show="preview" x-cloak class="absolute inset-0 w-full h-full object-cover">
                        
                        <div x-show="preview" x-cloak class="absolute inset-0 bg-black/40 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <span class="material-symbols-outlined text-white !text-[24px]">sync</span>
                            <span class="text-[10px] font-black text-white uppercase mt-1">Ganti Foto</span>
                        </div>
                    </div>
                </div>
                <p class="text-[10px] text-gray-400 font-bold leading-relaxed px-2 uppercase tracking-wide">Representasi visual membantu kasir mengenali produk lebih cepat.</p>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
                    <div class="grid grid-cols-1 gap-6">
                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Menu</label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Misal: Nasi Goreng Spesial"
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all">
                        </div>

                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kategori</label>
                            <div class="relative">
                                <select name="kategori_id" required
                                        class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-secondary transition-all appearance-none">
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach($kategoris as $k)
                                    <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                                <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Deskripsi Singkat</label>
                            <textarea name="deskripsi" rows="3" placeholder="Kandungan atau pelengkap menu..."
                                      class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-secondary transition-all resize-none">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Section 2: Pricing & Stock --}}
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Harga Jual per Porsi</label>
                    <div class="relative">
                        <span class="absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 font-black text-sm">Rp</span>
                        <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="0"
                               class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl pl-12 pr-5 py-3.5 text-lg font-black focus:outline-none focus:bg-white focus:border-secondary transition-all">
                    </div>
                </div>

                <div class="sm:col-span-2 bg-gray-50 rounded-2xl px-6 py-4 flex items-center justify-between border border-gray-100">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Ketersediaan</p>
                        <p class="text-xs text-gray-600 font-bold mt-0.5">Aktifkan agar menu tampil di layar kasir.</p>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="is_tersedia" :value="isTersedia ? '1' : '0'">
                        <button type="button" @click="isTersedia = !isTersedia"
                                class="relative inline-flex h-7 w-12 rounded-full transition-colors duration-200 ease-in-out focus:outline-none shadow-inner"
                                :class="isTersedia ? 'bg-secondary' : 'bg-gray-200'">
                            <span class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition duration-200 ease-in-out mt-1 ml-1"
                                  :class="isTersedia ? 'translate-x-5' : 'translate-x-0'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('menu.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-[0.2em] transition-colors">Batalkan</a>
            <button type="submit" class="px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 hover:scale-105 active:scale-95 transition-all">
                Simpan Menu Baru
            </button>
        </div>

    </form>
</div>
@endsection
