@extends('layouts.app')
@section('title', 'Katalog Menu')
@section('page-title', 'Katalog Menu Kantin')

@section('content')
<div x-data="{ 
    showAdd: @if($errors->hasAny(['nama', 'kategori_id', 'harga', 'deskripsi', 'gambar']) && !old('_method')) true @else false @endif, 
    showEdit: @if($errors->hasAny(['nama', 'kategori_id', 'harga', 'deskripsi', 'gambar']) && old('_method') === 'PUT') true @else false @endif,
    editData: {
        id: '{{ old('id') }}',
        nama: '{{ old('nama') }}',
        kategori_id: '{{ old('kategori_id') }}',
        harga: '{{ old('harga') }}',
        deskripsi: '{{ old('deskripsi') }}',
        is_tersedia: {{ old('is_tersedia') ? 'true' : 'true' }}
    }
}" class="space-y-5">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #982598, #E491C9);">
                    <span class="material-symbols-outlined text-white !text-[22px]">restaurant_menu</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Katalog Menu</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Manajemen penawaran makanan dan minuman kantin.</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <button @click="showAdd = true"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-black rounded-xl transition-all shadow-md hover:shadow-lg hover:scale-105 active:scale-95 shrink-0"
               style="background: linear-gradient(135deg, #982598, #E491C9);">
                <span class="material-symbols-outlined !text-[18px]">add</span>
                Tambah Menu
            </button>
            @endif
        </div>
        <div class="px-5 py-3.5 bg-gray-50/50">
            <form method="GET" class="flex flex-col sm:flex-row gap-3 items-center">
                <div class="flex-1 relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama menu..."
                           class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-xl pl-10 pr-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                </div>
                <div class="w-full sm:w-48 shrink-0">
                    <select name="kategori_id" class="w-full bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $k)
                        <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full sm:w-48 shrink-0">
                    <select name="status" class="w-full bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-secondary transition-all" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="tersedia" {{ request('status') === 'tersedia' ? 'selected' : '' }}>Menu Tersedia</option>
                        <option value="tidak_tersedia" {{ request('status') === 'tidak_tersedia' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                </div>
                @if(request('search') || request('kategori_id') || request('status'))
                <a href="{{ route('menu.index') }}"
                   class="shrink-0 w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-600 text-xs font-black rounded-xl hover:bg-gray-200 transition-colors border border-gray-200 flex items-center gap-1.5 justify-center">
                    <span class="material-symbols-outlined !text-[16px]">filter_alt_off</span> Reset
                </a>
                @endif
                <button type="submit" class="shrink-0 w-full sm:w-auto px-4 py-2 bg-primary text-white text-xs font-black rounded-xl hover:bg-primary/90 transition-colors">Cari</button>
            </form>
        </div>
    </div>

    {{-- Menu Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
        @forelse($menus as $menu)
        <div class="bg-white border border-gray-100 hover:border-secondary/30 rounded-2xl flex flex-col overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 group relative">
            
            <div class="absolute top-2.5 right-2.5 z-10 flex flex-col gap-1 items-end pointer-events-none">
                @if(!$menu->is_tersedia)
                <span class="text-[10px] font-black px-2 py-0.5 rounded-full bg-red-600 text-white uppercase tracking-wider shadow">Non-Aktif</span>
                @endif
            </div>

            <div class="aspect-square bg-gray-50 relative overflow-hidden shrink-0">
                @if($menu->gambar)
                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-50 to-gray-100">
                    <span class="material-symbols-outlined text-gray-300 !text-[40px]">restaurant</span>
                </div>
                @endif
                <div class="absolute inset-0 bg-gradient-to-t from-black/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
            </div>
            
            <div class="p-3.5 flex flex-col flex-1">
                <div>
                    <h3 class="text-sm font-black text-gray-900 leading-tight line-clamp-1">{{ $menu->nama }}</h3>
                    <p class="text-[10px] text-secondary font-bold uppercase tracking-wider mt-0.5">{{ $menu->kategori?->nama }}</p>
                </div>
                <div class="mt-auto pt-3">
                    <p class="text-sm text-gray-900 font-black tracking-tight">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between mt-2.5 pt-2.5 border-t border-dashed border-gray-100">
                        @if(auth()->user()->isAdmin())
                        <div class="flex items-center gap-1">
                            <button type="button"
                               @click="showEdit = true; editData = { 
                                   id: '{{ $menu->id }}', 
                                   nama: '{{ $menu->nama }}', 
                                   kategori_id: '{{ $menu->kategori_id }}', 
                                   harga: '{{ $menu->harga }}', 
                                   deskripsi: '{{ $menu->deskripsi }}',
                                   is_tersedia: {{ $menu->is_tersedia ? 'true' : 'false' }}
                               }"
                               class="p-1.5 hover:bg-primary/10 text-gray-400 hover:text-primary rounded-lg transition-all" title="Edit">
                                <span class="material-symbols-outlined !text-[16px]">edit</span>
                            </button>
                            <button type="button"
                                    @click="$dispatch('confirm', {
                                        title: 'Hapus Menu?',
                                        message: 'Apakah Anda yakin ingin menghapus menu {{ $menu->nama }}?',
                                        action: '{{ route('menu.destroy', $menu->id) }}',
                                        method: 'DELETE'
                                    })"
                                    class="p-1.5 hover:bg-red-50 text-gray-400 hover:text-red-600 rounded-lg transition-all" title="Hapus">
                                <span class="material-symbols-outlined !text-[16px]">delete</span>
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full py-16 bg-white border border-gray-100 rounded-2xl text-center shadow-sm flex flex-col items-center gap-4">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f5f0ff, #fce4f7);">
                <span class="material-symbols-outlined !text-[32px]" style="color: #982598;">restaurant_menu</span>
            </div>
            <div>
                <p class="font-black text-gray-900 mb-1">Katalog Masih Kosong</p>
                <p class="text-sm text-gray-400">Silakan mulai dengan menambahkan menu pertama Anda.</p>
            </div>
            @if(auth()->user()->isAdmin())
            <button @click="showAdd = true" class="px-5 py-2 text-white text-sm font-bold rounded-xl" style="background: linear-gradient(135deg, #982598, #E491C9);">+ Tambah Menu</button>
            @endif
        </div>
        @endforelse
    </div>

    {{-- MODAL TAMBAH --}}
    <div x-show="showAdd" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAdd" x-transition.opacity @click="showAdd = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAdd" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Tambah Menu Baru</h3>
                            <button type="button" @click="showAdd = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Menu</label>
                                    <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Nasi Goreng Spesial"
                                           class="w-full bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                                    @error('nama') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Kategori</label>
                                    <select name="kategori_id" required class="w-full bg-gray-50 border @error('kategori_id') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Harga (Rp)</label>
                                    <input type="number" name="harga" value="{{ old('harga') }}" required placeholder="0"
                                           class="w-full bg-gray-50 border @error('harga') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Foto Menu</label>
                                    <input type="file" name="gambar" accept="image/*"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-xs focus:outline-none transition-all">
                                    <p class="text-[9px] text-gray-400 mt-1.5 font-medium italic">Format: JPG, PNG, WEBP (Maks. 2MB)</p>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3" placeholder="Jelaskan detail menu..."
                                              class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary transition-all">{{ old('deskripsi') }}</textarea>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                    <input type="checkbox" name="is_tersedia" value="1" checked id="add_tersedia" class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                                    <label for="add_tersedia" class="text-xs font-bold text-gray-700 cursor-pointer">Menu Tersedia untuk Dipesan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-secondary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-secondary/20">Simpan Menu</button>
                        <button type="button" @click="showAdd = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- MODAL EDIT --}}
    <div x-show="showEdit" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showEdit" x-transition.opacity @click="showEdit = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showEdit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                <form :action="'{{ url('menu') }}/' + editData.id" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="editData.id">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Perbarui Data Menu</h3>
                            <button type="button" @click="showEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Menu</label>
                                    <input type="text" name="nama" x-model="editData.nama" required
                                           class="w-full bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                                    @error('nama') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Kategori</label>
                                    <select name="kategori_id" x-model="editData.kategori_id" required class="w-full bg-gray-50 border @error('kategori_id') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary focus:ring-2 focus:ring-secondary/10 transition-all">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($kategoris as $k)
                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Harga (Rp)</label>
                                    <input type="number" name="harga" x-model="editData.harga" required
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary transition-all">
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Ganti Foto (Opsional)</label>
                                    <input type="file" name="gambar" accept="image/*"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-2.5 text-xs focus:outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi</label>
                                    <textarea name="deskripsi" rows="3" x-model="editData.deskripsi"
                                              class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-secondary transition-all"></textarea>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100">
                                    <input type="checkbox" name="is_tersedia" value="1" x-model="editData.is_tersedia" id="edit_tersedia" class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary">
                                    <label for="edit_tersedia" class="text-xs font-bold text-gray-700 cursor-pointer">Menu Tersedia untuk Dipesan</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-secondary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-secondary/20">Simpan Perubahan</button>
                        <button type="button" @click="showEdit = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
