@extends('layouts.app')
@section('title', 'Kategori Baru')
@section('page-title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mt-4 max-w-full">
    <div class="bg-white border border-gray-200 rounded-lg p-6 shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="mb-6 border-b border-gray-200 pb-4 flex justify-between items-center">
            <div>
                <h3 class="text-xl font-bold text-gray-900">Form Kategori Baru</h3>
                <p class="text-sm text-gray-500 mt-1">Buat variasi kelompok baru untuk menu makanan & minuman.</p>
            </div>
            <a href="{{ route('kategori.index') }}" class="text-sm px-4 py-2 hover:bg-gray-100 rounded-md font-bold text-gray-600 transition-colors">Batal</a>
        </div>

        <form method="POST" action="{{ route('kategori.store') }}" class="space-y-6">
            @csrf
            
            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Nama Kategori <span class="text-red-500">*</span></label>
                <input type="text" name="nama" value="{{ old('nama') }}" required autofocus
                       class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                       placeholder="Contoh: Paket Hemat, Minuman Dingin...">
                @error('nama') <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="space-y-1.5">
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Deskripsi Singkat <span class="text-gray-400 font-normal normal-case">(Opsional)</span></label>
                <textarea name="deskripsi" rows="3"
                          class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-2.5 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors resize-none"
                          placeholder="Ketikan penjelasan terkait kelompok kategori ini... (contoh: Semua menu bundling spesial dengan potongan harga)">{{ old('deskripsi') }}</textarea>
                @error('deskripsi') <p class="text-xs text-red-600 font-medium mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="pt-4 border-t border-gray-100 flex justify-end">
                <button type="submit" class="px-6 py-2.5 bg-primary hover:bg-[#0c0d24] text-white text-sm font-bold tracking-wider uppercase rounded-lg shadow-sm transition-colors focus:ring-2 focus:ring-offset-2 focus:ring-primary inline-flex items-center gap-2">
                    Simpan Kategori Baru
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
