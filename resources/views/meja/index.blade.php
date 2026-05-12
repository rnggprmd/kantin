@extends('layouts.app')
@section('title', 'Manajemen Lokasi & Meja')
@section('page-title', 'QR & Lokasi Pemesanan')

@section('content')
<div x-data="{ 
    showAddModal: false, 
    showEditModal: false,
    selectedMeja: { id: '', nama: '', is_aktif: 1, kode: '' },
    openEdit(meja) {
        this.selectedMeja = { ...meja };
        this.showEditModal = true;
    }
}" class="space-y-6">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #15173D, #2d1b69);">
                    <span class="material-symbols-outlined text-white !text-[22px]">qr_code_2</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Daftar Lokasi & Meja</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Kelola titik pemesanan barcode untuk siswa secara real-time.</p>
                </div>
            </div>
            <button @click="showAddModal = true"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-black rounded-xl transition-all shadow-md hover:shadow-lg hover:scale-105 active:scale-95 shrink-0"
               style="background: linear-gradient(135deg, #1e3a5f, #15173D);">
                <span class="material-symbols-outlined !text-[18px]">add</span>
                Tambah Lokasi
            </button>
        </div>
    </div>

    {{-- Grid Meja --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($mejas as $meja)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg transition-all duration-300">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/5 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined !text-[20px]">qr_code_2</span>
                    </div>
                    <span class="px-2 py-0.5 rounded-lg text-[9px] font-black uppercase tracking-wider {{ $meja->is_aktif ? 'bg-green-50 text-green-600 border border-green-100' : 'bg-red-50 text-red-600 border border-red-100' }}">
                        {{ $meja->is_aktif ? 'Aktif' : 'Non-Aktif' }}
                    </span>
                </div>
                
                <h3 class="font-black text-gray-900 text-sm mb-1">{{ $meja->nama }}</h3>
                <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mb-4">Kode: {{ $meja->kode }}</p>

                {{-- Mini QR Preview (Placeholder using API) --}}
                <div class="aspect-square bg-gray-50 rounded-xl mb-4 flex items-center justify-center border border-dashed border-gray-200 overflow-hidden group-hover:border-primary/20 transition-colors">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ url('/order/' . $meja->kode) }}" 
                         alt="QR Meja" class="w-3/4 h-3/4 opacity-80 group-hover:opacity-100 transition-opacity">
                </div>

                <div class="flex gap-2">
                    <button @click="openEdit({{ json_encode($meja) }})" 
                            class="flex-1 py-2 bg-gray-50 text-gray-600 text-[10px] font-black rounded-lg hover:bg-gray-100 transition-colors uppercase tracking-widest">
                        Edit
                    </button>
                    <a href="https://api.qrserver.com/v1/create-qr-code/?size=500x500&data={{ url('/order/' . $meja->kode) }}" 
                       target="_blank" title="Cetak QR Code"
                       class="w-10 flex flex-shrink-0 items-center justify-center bg-primary/5 text-primary rounded-lg hover:bg-primary/10 transition-colors">
                        <span class="material-symbols-outlined !text-[16px]">print</span>
                    </a>
                    <button x-data="{ copied: false }" title="Salin Link Pemesanan"
                            @click="navigator.clipboard.writeText('{{ url('/order/' . $meja->kode) }}').then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
                            class="w-10 flex flex-shrink-0 items-center justify-center bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors relative">
                        <span x-show="!copied" class="material-symbols-outlined !text-[16px]">link</span>
                        <span x-show="copied" x-cloak class="material-symbols-outlined !text-[16px]">check</span>
                    </button>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-24 text-center bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center gap-3">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f0f4ff, #e8ecf8);">
                <span class="material-symbols-outlined text-gray-300 !text-[32px]">qr_code_scanner</span>
            </div>
            <div>
                <p class="font-black text-gray-900 text-lg">Tidak ada lokasi terdaftar</p>
                <p class="text-xs text-gray-400 mt-1">Tambahkan lokasi/meja baru untuk mulai mencetak QR Code.</p>
            </div>
        </div>
        @endforelse
    </div>

    {{-- Add Modal --}}
    <div x-show="showAddModal" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAddModal" x-transition.opacity @click="showAddModal = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAddModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form action="{{ route('meja.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Tambah Lokasi</h3>
                            <button type="button" @click="showAddModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Lokasi / Nomor Meja</label>
                                <input type="text" name="nama" required placeholder="Contoh: Meja 01, Kantin Stand A, dsb"
                                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Simpan Lokasi</button>
                        <button type="button" @click="showAddModal = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div x-show="showEditModal" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEditModal" x-transition.opacity @click="showEditModal = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showEditModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form :action="'{{ url('meja') }}/' + selectedMeja.id" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Edit Lokasi</h3>
                            <button type="button" @click="showEditModal = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Lokasi / Nomor Meja</label>
                                <input type="text" name="nama" x-model="selectedMeja.nama" required
                                       class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Status Aktivitas</label>
                                <select name="is_aktif" x-model="selectedMeja.is_aktif"
                                        class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                                    <option value="1">Aktif (Dapat Dipesan)</option>
                                    <option value="0">Non-Aktif (Tutup)</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex justify-between items-center rounded-b-2xl border-t border-gray-100">
                        <button type="button" 
                                @click="if(confirm('Hapus lokasi ini? Semua QR terkait tidak akan berfungsi.')) { $el.closest('form').querySelector('input[name=_method]').value = 'DELETE'; $el.closest('form').submit(); }"
                                class="w-full sm:w-auto px-6 py-2.5 bg-red-50 text-red-600 border border-red-100 text-sm font-bold rounded-xl hover:bg-red-100 transition-all">
                            Hapus Lokasi
                        </button>
                        <div class="flex sm:flex-row-reverse gap-3 mt-3 sm:mt-0 w-full sm:w-auto">
                            <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Perbarui</button>
                            <button type="button" @click="showEditModal = false" class="w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection
