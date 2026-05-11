@extends('layouts.app')
@section('title', 'Kategori Baru')
@section('page-title', 'Registrasi Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #1e3a5f, #15173D);">
            <span class="material-symbols-outlined text-blue-300 !text-[24px]">category</span>
        </div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Kategori</h2>
            <p class="text-xs text-gray-400 font-medium mt-1">Buat grup baru untuk mengelompokkan menu.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('kategori.store') }}" class="space-y-6">
        @csrf
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="relative group">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Kategori</label>
                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Misal: Makanan Berat"
                       class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
            </div>

            <div class="relative group">
                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" rows="4" placeholder="Penjelasan singkat tentang kategori ini..."
                          class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all resize-none">{{ old('deskripsi') }}</textarea>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('kategori.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
            <button type="submit" class="px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 transition-all">
                Simpan Kategori
            </button>
        </div>
    </form>
</div>
@endsection
