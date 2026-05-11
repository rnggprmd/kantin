@extends('layouts.app')
@section('title', 'Menu Baru')
@section('page-title', 'Registrasi Menu Baru')

@section('content')
<div class="max-w-5xl mx-auto py-6" x-data="{ 
    preview: null, 
    isTersedia: {{ old('is_tersedia', 'true') === 'true' || old('is_tersedia') === '1' ? 'true' : 'false' }} 
}">

    <div class="flex items-center justify-between pb-6 mb-8 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Menu Baru</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Tambahkan item makanan/minuman ke dalam Etalase Kasir POS.</p>
        </div>
        <a href="{{ route('menu.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 transition-all">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('menu.store') }}" enctype="multipart/form-data" class="space-y-10">
        @csrf

        {{-- Section 1: Visual --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Visual Menu</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Representasi visual sangat penting agar kasir cepat mengenali pesanan. Pastikan gambar jelas dan menarik.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl p-1 shadow-sm ring-1 ring-gray-900/5">
                    <div class="relative border-2 border-dashed border-gray-300 hover:border-primary/50 bg-gray-50/50 hover:bg-primary/5 rounded-lg transition-all overflow-hidden group min-h-[16rem] flex flex-col items-center justify-center"
                         @dragover.prevent="$el.classList.add('bg-primary/10', 'border-primary')" 
                         @dragleave.prevent="$el.classList.remove('bg-primary/10', 'border-primary')"
                         @drop.prevent="
                            $el.classList.remove('bg-primary/10', 'border-primary');
                            const file = $event.dataTransfer.files[0];
                            if (file && file.type.startsWith('image/')) {
                                preview = URL.createObjectURL(file);
                                $refs.fileInput.files = $event.dataTransfer.files;
                            }">
                        
                        <input type="file" name="gambar" accept="image/*" x-ref="fileInput"
                               @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : null"
                               class="absolute inset-0 opacity-0 cursor-pointer w-full h-full z-10 block">
                        
                        <div class="p-8 text-center flex flex-col items-center" x-show="!preview" x-transition>
                            <div class="w-16 h-16 bg-white shadow-sm ring-1 ring-gray-900/5 rounded-full flex items-center justify-center mb-4 group-hover:scale-110 group-hover:shadow-md transition-all duration-300">
                                <svg class="w-8 h-8 text-tertiary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <p class="text-gray-900 font-bold text-base">Unggah Foto Menu</p>
                            <p class="text-gray-500 text-xs mt-1.5 font-medium max-w-xs leading-relaxed">Format JPG, PNG, atau WEBP. Maksimal ukuran file 2MB.</p>
                            <span class="mt-4 px-4 py-1.5 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-700 shadow-sm group-hover:bg-gray-50">Browser File</span>
                        </div>
                        
                        <div x-show="preview" x-cloak class="absolute inset-0 z-0 p-2">
                            <img :src="preview" class="w-full h-full object-cover rounded-md shadow-sm">
                            <div class="absolute inset-2 flex items-center justify-center bg-gray-900/50 opacity-0 group-hover:opacity-100 transition-opacity rounded-md cursor-pointer backdrop-blur-sm">
                                <div class="flex flex-col items-center">
                                    <svg class="w-8 h-8 text-white mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span class="text-white text-sm font-bold uppercase tracking-wide">Ganti Foto</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 2: Data --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Spesifikasi Dasar</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Berikan nama unik dan kategori yang relevan agar produk mudah dikelompokkan dalam pencarian cerdas POS.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2 relative">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Menu <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                                   placeholder="Contoh: Ayam Geprek Spesial">
                        </div>
                        
                        <div class="sm:col-span-2 relative">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Pilih Kategori <span class="text-red-500">*</span></label>
                            <select name="kategori_id" required
                                    class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors appearance-none">
                                <option value="">-- Tentukan Kategori --</option>
                                @foreach($kategoris as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                @endforeach
                            </select>
                            <svg class="absolute right-4 top-10 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                        
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Deskripsi Kandungan / Pelengkap <span class="text-gray-400 font-normal normal-case">(Opsional)</span></label>
                            <textarea name="deskripsi" rows="3"
                                      class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white resize-none transition-colors"
                                      placeholder="Ketikkan info komposisi bahan atau catatan khusus...">{{ old('deskripsi') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 3: Stok & Harga --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Perdagangan & Inventori</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Tetapkan nilai jual dan manajemen persediaan. Pastikan status "Tersedia" aktif jika item siap ditaruh di keranjang kasir.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8 space-y-8">
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Harga Jual per Porsi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none border-r border-gray-300/50 bg-gray-50 rounded-l-lg pr-3">
                                    <span class="text-gray-500 font-bold text-sm">Rp</span>
                                </div>
                                <input type="number" name="harga" value="{{ old('harga') }}" required min="0" placeholder="0"
                                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg pl-14 pr-4 py-3 text-base font-black focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kapasitas Stok <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0"
                                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg pl-4 pr-12 py-3 text-base font-black focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-right">
                                <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                    <span class="text-gray-400 font-bold text-sm">Porsi</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Alpine Toggle Switch --}}
                    <div class="bg-gray-50/80 rounded-lg p-5 border border-gray-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Visibilitas Pos (Status Aktif)</h4>
                            <p class="text-xs text-gray-500 mt-1">Sembunyikan Menu Ini jika sedang kosong di dapur.</p>
                        </div>
                        
                        <input type="hidden" name="is_tersedia" :value="isTersedia ? '1' : '0'">
                        <button type="button" 
                                @click="isTersedia = !isTersedia"
                                class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                                :class="isTersedia ? 'bg-secondary' : 'bg-gray-300'"
                                role="switch" :aria-checked="isTersedia.toString()">
                            <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                  :class="isTersedia ? 'translate-x-5' : 'translate-x-0'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 mb-4 border-t border-gray-200 flex justify-end items-center gap-4">
            <a href="{{ route('menu.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-[#2a2c5a] hover:from-[#0c0d24] hover:to-[#1a1b3c] text-white text-sm font-bold tracking-wider uppercase rounded-lg shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-primary inline-flex items-center gap-2">
                Simpan Ke Katalog
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </form>
</div>
@endsection
