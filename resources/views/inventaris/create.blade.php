@extends('layouts.app')
@section('title', 'Entri Aset Inventaris')
@section('page-title', 'Akuisisi Aset Baru')

@section('content')
<div class="max-w-5xl mx-auto py-6">

    <div class="flex items-center justify-between pb-6 mb-8 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Pencatatan Inventaris</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Lakukan validasi material dan perlengkapan operasional dapur/kantin.</p>
        </div>
        <a href="{{ route('inventaris.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 transition-all">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('inventaris.store') }}" class="space-y-10">
        @csrf

        {{-- Section 1: Data Utama --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Identitas Aset</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Berikan penamaan spesifik untuk mempermudah audit barang di masa mendatang.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Barang / Material <span class="text-red-500">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                                   placeholder="Misal: Beras Pandan Wangi 25kg">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Keterangan Spesifikasi <span class="text-gray-400 font-normal normal-case">(Opsional)</span></label>
                            <textarea name="keterangan" rows="3"
                                      class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white resize-none transition-colors"
                                      placeholder="Tambahkan info merk, ukuran, atau lokasi simpan...">{{ old('keterangan') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 2: Stok & Manajemen --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Manajemen Volume & Biaya</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Kendali jumlah ketersediaan dan penetapan harga beli modal untuk laporan beban.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Satuan Unit <span class="text-red-500">*</span></label>
                            <input type="text" name="satuan" value="{{ old('satuan') }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                                   placeholder="kg, box, pcs, dll">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Harga Beli Rata-Rata <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold text-sm">Rp</span>
                                <input type="number" name="harga_beli" value="{{ old('harga_beli', 0) }}" required min="0"
                                       class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg pl-12 pr-4 py-3 text-base font-black focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kuantitas Stok Saat Ini <span class="text-red-500">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0" step="0.01"
                                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-base font-black focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors text-right">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2 text-red-600">Ambang Batas Minimum (Peringatan) <span class="text-red-500">*</span></label>
                            <input type="number" name="stok_minimum" value="{{ old('stok_minimum', 0) }}" required min="0" step="0.01"
                                   class="w-full bg-white border border-red-200 text-red-900 rounded-lg px-4 py-3 text-base font-black focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-colors text-right">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 3: Relasi Bisnis --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Rantai Pasok</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Integrasikan asal barang untuk manajemen kerjasama distributor.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Pemasok (Supplier)</label>
                        <input type="text" name="supplier" value="{{ old('supplier') }}"
                               class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                               placeholder="Nama PT, Toko, atau Individu">
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 mb-4 border-t border-gray-200 flex justify-end items-center gap-4">
            <a href="{{ route('inventaris.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-[#2a2c5a] hover:from-[#0c0d24] hover:to-[#1a1b3c] text-white text-sm font-bold tracking-wider uppercase rounded-lg shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-primary inline-flex items-center gap-2">
                Rekam Aset Baru
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </form>
</div>
@endsection
