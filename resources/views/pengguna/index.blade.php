@extends('layouts.app')
@section('title', 'Manajemen Pengguna')
@section('page-title', 'Akses Pengguna')

@section('content')
<div x-data="{ 
    showAdd: @if($errors->hasAny(['name', 'email', 'role', 'phone', 'password', 'is_active']) && !old('_method')) true @else false @endif, 
    showEdit: @if($errors->hasAny(['name', 'email', 'role', 'phone', 'password', 'is_active']) && old('_method') === 'PUT') true @else false @endif,
    editData: {
        id: '{{ old('id') }}',
        name: '{{ old('name') }}',
        email: '{{ old('email') }}',
        role: '{{ old('role') }}',
        phone: '{{ old('phone') }}',
        is_active: {{ old('is_active') ? 'true' : 'true' }}
    }
}" class="space-y-5">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5 border-b border-gray-100">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #2d1b69, #4a1d96);">
                    <span class="material-symbols-outlined text-purple-300 !text-[22px]">admin_panel_settings</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Manajemen Pengguna</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Pemeliharaan izin akses dan otoritas personel operasional.</p>
                </div>
            </div>
            <button @click="showAdd = true"
               class="inline-flex items-center gap-2 px-5 py-2.5 text-white text-sm font-black rounded-xl transition-all shadow-md hover:shadow-lg hover:scale-105 active:scale-95 shrink-0"
               style="background: linear-gradient(135deg, #2d1b69, #4a1d96);">
                <span class="material-symbols-outlined !text-[18px]">person_add</span>
                Registrasi Karyawan
            </button>
        </div>
        <div class="px-5 py-3.5 bg-gray-50/50">
            <form method="GET" x-data x-ref="penggunaForm" class="flex flex-col sm:flex-row items-center gap-3">
                <div class="flex-1 relative w-full">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400">search</span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           @input.debounce.500ms="$refs.penggunaForm.submit()"
                           placeholder="Cari nama, email..."
                           class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-xl pl-10 pr-3 py-2 text-sm focus:outline-none focus:border-primary focus:ring-2 focus:ring-primary/10 transition-all">
                </div>
                <div class="w-full sm:w-52">
                    <select name="role" class="w-full bg-white border border-gray-200 text-gray-700 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-primary transition-all" onchange="this.form.submit()">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                        <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                    </select>
                </div>
                @if(request('search') || request('role'))
                <a href="{{ route('pengguna.index') }}" class="w-full sm:w-auto px-4 py-2 bg-gray-100 text-gray-600 text-xs font-black rounded-xl hover:bg-gray-200 transition-colors border border-gray-200 flex items-center gap-1.5 justify-center">
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
                    <tr style="background: linear-gradient(90deg, #f5f0ff, #f0f2f8);">
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center w-12">No</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Identitas Pegawai</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Otoritas</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-center">Status</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest">Bergabung</th>
                        <th class="px-5 py-3.5 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right w-28">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($penggunas as $p)
                    <tr class="hover:bg-purple-50/20 transition-colors">
                        <td class="px-5 py-3.5 text-center text-xs text-gray-400 font-bold">
                            {{ ($penggunas->currentPage() - 1) * $penggunas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl shrink-0 flex items-center justify-center text-sm font-black text-white"
                                     style="background: linear-gradient(135deg, #2d1b69, #4a1d96);">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-black text-gray-900 truncate">
                                        {{ $p->name }}
                                        @if($p->id === auth()->id())
                                        <span class="text-[9px] text-secondary font-black uppercase tracking-wider ml-1 bg-secondary/10 px-1.5 py-0.5 rounded-full">SAYA</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] text-gray-400 font-medium truncate">{{ $p->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            @if($p->role === 'admin')
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide bg-primary/5 text-primary border border-primary/10">
                                    <span class="material-symbols-outlined !text-[13px]">shield</span> Administrator
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-black uppercase tracking-wide bg-gray-50 text-gray-500 border border-gray-100">
                                    <span class="material-symbols-outlined !text-[13px]">point_of_sale</span> Kasir
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($p->is_active)
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-green-50 text-green-700 text-[10px] font-black uppercase rounded-full border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 inline-block"></span> Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-red-50 text-red-700 text-[10px] font-black uppercase rounded-full border border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 inline-block"></span> Terblokir
                                </span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-400 text-xs font-medium">{{ $p->created_at->format('d M Y') }}</td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-1.5">
                                <button type="button"
                                   @click="showEdit = true; editData = { 
                                       id: '{{ $p->id }}', 
                                       name: '{{ $p->name }}', 
                                       email: '{{ $p->email }}', 
                                       role: '{{ $p->role }}', 
                                       phone: '{{ $p->phone }}',
                                       is_active: {{ $p->is_active ? 'true' : 'false' }}
                                   }"
                                   class="p-2 text-gray-400 hover:text-primary hover:bg-primary/5 rounded-lg transition-all" title="Edit">
                                    <span class="material-symbols-outlined !text-[18px]">manage_accounts</span>
                                </button>
                                @if($p->id !== auth()->id())
                                <button type="button"
                                        @click="$dispatch('confirm', { title: 'Hapus Pengguna?', message: 'Hapus akses {{ $p->name }}?', action: '{{ route('pengguna.destroy', $p->id) }}', method: 'DELETE', confirmText: 'Ya, Hapus' })"
                                        class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all">
                                    <span class="material-symbols-outlined !text-[18px]">delete</span>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-gray-200 !text-[48px]">group</span>
                                <p class="font-black text-gray-400">Daftar Karyawan Kosong</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($penggunas->hasPages())
        <div class="px-5 py-3.5 border-t border-gray-100 bg-gray-50/30">{{ $penggunas->links() }}</div>
        @endif
    </div>

    {{-- MODAL TAMBAH --}}
    <div x-show="showAdd" x-cloak class="fixed inset-0 z-[110] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="showAdd" x-transition.opacity @click="showAdd = false" class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div x-show="showAdd" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full border border-gray-100">
                <form action="{{ route('pengguna.store') }}" method="POST">
                    @csrf
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Registrasi Karyawan Baru</h3>
                            <button type="button" @click="showAdd = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                                           class="w-full bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('name') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Alamat Email</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@kantinmaria.com"
                                           class="w-full bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('email') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Otoritas / Role</label>
                                    <select name="role" required class="w-full bg-gray-50 border @error('role') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                        <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir (Operator POS)</option>
                                        <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator (Manajer)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Password</label>
                                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                                           class="w-full bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('password') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" required placeholder="Ulangi password"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 mt-2">
                                    <input type="checkbox" name="is_active" value="1" checked id="add_active" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    <label for="add_active" class="text-xs font-bold text-gray-700 cursor-pointer">Akun Aktif (Dapat Login)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Daftarkan Pegawai</button>
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
                <form :action="'{{ url('pengguna') }}/' + editData.id" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" :value="editData.id">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-xl font-black text-gray-900 tracking-tight">Edit Akses Pengguna</h3>
                            <button type="button" @click="showEdit = false" class="text-gray-400 hover:text-gray-600 transition-colors">
                                <span class="material-symbols-outlined">close</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Nama Lengkap</label>
                                    <input type="text" name="name" x-model="editData.name" required
                                           class="w-full bg-gray-50 border @error('name') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('name') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Alamat Email</label>
                                    <input type="email" name="email" x-model="editData.email" required
                                           class="w-full bg-gray-50 border @error('email') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('email') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Role</label>
                                    <select name="role" x-model="editData.role" required class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                        <option value="kasir">Kasir</option>
                                        <option value="admin">Administrator</option>
                                    </select>
                                </div>
                            </div>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Ganti Password (Opsional)</label>
                                    <input type="password" name="password" placeholder="Kosongkan jika tidak diganti"
                                           class="w-full bg-gray-50 border @error('password') border-red-500 @else border-gray-200 @enderror text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                    @error('password') <p class="text-[10px] text-red-500 font-bold mt-1">{{ $message }}</p> @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-1.5">Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" placeholder="Ulangi password baru"
                                           class="w-full bg-gray-50 border border-gray-200 text-gray-900 rounded-xl px-4 py-3 text-sm focus:outline-none focus:border-primary transition-all">
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl border border-gray-100 mt-2">
                                    <input type="checkbox" name="is_active" value="1" x-model="editData.is_active" id="edit_active" class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                    <label for="edit_active" class="text-xs font-bold text-gray-700 cursor-pointer">Akun Aktif (Dapat Login)</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-2xl border-t border-gray-100">
                        <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-primary text-white text-sm font-black rounded-xl hover:opacity-90 transition-all shadow-lg shadow-primary/20">Simpan Perubahan</button>
                        <button type="button" @click="showEdit = false" class="mt-3 sm:mt-0 w-full sm:w-auto px-6 py-3 bg-white border border-gray-300 text-gray-700 text-sm font-bold rounded-xl hover:bg-gray-50 transition-all">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
