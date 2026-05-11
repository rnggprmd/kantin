@extends('layouts.app')
@section('title', 'Manajemen Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
<div x-data="{ 
    showAdd: @if($errors->hasAny(['nama', 'deskripsi']) && !old('_method')) true @else false @endif, 
    showEdit: @if($errors->hasAny(['nama', 'deskripsi']) && old('_method') === 'PUT') true @else false @endif,
    editData: {
        id: '{{ old('id') }}',
        nama: '{{ old('nama') }}',
        deskripsi: '{{ old('deskripsi') }}'
    }
}" class="space-y-5">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #1e3a5f, #15173D);">
                    <span class="material-symbols-outlined text-blue-300 !text-[22px]">category</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Kategori Menu</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Pengelompokan jenis menu makanan & minuman.</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <button @click="showAdd = true"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-black rounded-xl transition-all shadow-md hover:shadow-lg hover:scale-105 active:scale-95 shrink-0"
               style="background: linear-gradient(135deg, #1e3a5f, #15173D);">
                <span class="material-symbols-outlined !text-[18px]">add</span>
                Tambah Kategori
            </button>
            @endif
        </div>

        {{-- Filter Bar --}}
        <div class="px-5 py-3.5 bg-gray-50/50">
            <form method="GET" x-data x-ref="filterForm" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex-1 relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari kategori berdasarkan nama..."
                           class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-xl pl-10 pr-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                </div>
                <div class="w-full sm:w-48">
                    <select name="status" class="w-full bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all" onchange="this.form.submit()">
                        <option value="">Semua Status</option>
                        <option value="digunakan" {{ request('status') === 'digunakan' ? 'selected' : '' }}>Digunakan (Aktif)</option>
                        <option value="kosong" {{ request('status') === 'kosong' ? 'selected' : '' }}>Kosong (Belum Dipakai)</option>
                    </select>
                </div>
                @if(request('search') || request('status'))
                <a href="{{ route('kategori.index') }}"
                   class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-600 text-xs font-black rounded-xl hover:bg-gray-200 transition-colors border border-gray-200 flex items-center gap-1.5 justify-center">
                    <span class="material-symbols-outlined !text-[16px]">filter_alt_off</span> Hapus Filter
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead>
                    <tr style="background: linear-gradient(90deg, #f0f4ff, #f0f2f8);">
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center w-12">No</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Nama Kategori</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest w-1/3">Deskripsi</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center">Total Menu</th>
                        @if(auth()->user()->isAdmin())
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right">Tindakan</th>
                        @endif
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($kategoris as $k)
                    <tr class="hover:bg-blue-50/20 transition-colors group">
                        <td class="px-5 py-3.5 text-center text-xs text-gray-400 font-bold">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center text-sm font-black"
                                     style="background: linear-gradient(135deg, #f0f4ff, #e8ecf8); color: #15173D;">
                                    {{ strtoupper(substr($k->nama, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-gray-900">{{ $k->nama }}</p>
                                    <p class="text-[10px] text-gray-400 font-mono mt-0.5">slug: {{ $k->slug }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <p class="text-xs text-gray-500 line-clamp-2 leading-relaxed">{{ $k->deskripsi ?? '—' }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($k->menus_count > 0)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-primary/5 text-primary text-xs font-black rounded-full border border-primary/10">
                                    <span class="material-symbols-outlined !text-[13px]">restaurant_menu</span>
                                    {{ $k->menus_count }} Item
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-amber-50 text-amber-600 text-xs font-black rounded-full border border-amber-100">
                                    <span class="material-symbols-outlined !text-[13px]">warning</span>
                                    Kosong
                                </span>
                            @endif
                        </td>
                        @if(auth()->user()->isAdmin())
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button"
                                   @click="showEdit = true; editData = { id: '{{ $k->id }}', nama: '{{ $k->nama }}', deskripsi: '{{ $k->deskripsi }}' }"
                                   class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Edit">
                                    <span class="material-symbols-outlined !text-[18px]">edit</span>
                                </button>
                                @if($k->menus_count === 0)
                                <button type="button"
                                        @click="$dispatch('confirm', {
                                            title: 'Hapus Kategori?',
                                            message: 'Apakah Anda yakin ingin menghapus kategori {{ $k->nama }}?',
                                            action: '{{ route('kategori.destroy', $k->id) }}',
                                            method: 'DELETE'
                                        })"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all" title="Hapus">
                                    <span class="material-symbols-outlined !text-[18px]">delete</span>
                                </button>
                                @else
                                <button disabled class="p-2 text-gray-200 cursor-not-allowed" title="Kategori sedang digunakan">
                                    <span class="material-symbols-outlined !text-[18px]">delete</span>
                                </button>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-gray-200 !text-[48px]">category</span>
                                <p class="font-black text-gray-400">Belum Ada Kategori</p>
                                <p class="text-xs text-gray-300">Klik tombol tambah untuk membuat kategori pertama.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- MODAL TAMBAH --}}
    <div x-show="showAdd" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAdd" x-transition.opacity @click="showAdd = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAdd" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form action="{{ route('kategori.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Tambah Kategori</h3>
                            <button type="button" @click="showAdd = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Kategori</label>
                                <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Makanan Berat"
                                       class="w-full bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                                @error('nama') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi (Opsional)</label>
                                <textarea name="deskripsi" rows="3" placeholder="Penjelasan singkat kategori ini..."
                                          class="w-full bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Simpan Kategori</button>
                        <button type="button" @click="showAdd = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
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
            <div x-show="showEdit" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                <form :action="'{{ url('kategori') }}/' + editData.id" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="editData.id">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Edit Kategori</h3>
                            <button type="button" @click="showEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Kategori</label>
                                <input type="text" name="nama" x-model="editData.nama" required
                                       class="w-full bg-gray-50 border @error('nama') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                                @error('nama') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Deskripsi (Opsional)</label>
                                <textarea name="deskripsi" rows="3" x-model="editData.deskripsi"
                                          class="w-full bg-gray-50 border @error('deskripsi') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all"></textarea>
                                @error('deskripsi') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-6 py-2.5 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Perbarui Kategori</button>
                        <button type="button" @click="showEdit = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-2.5 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
