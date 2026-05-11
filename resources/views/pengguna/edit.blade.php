@extends('layouts.app')
@section('title', 'Edit Pengguna')
@section('page-title', 'Modifikasi Personel')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #2d1b69, #4a1d96);">
            <span class="material-symbols-outlined text-purple-300 !text-[24px]">manage_accounts</span>
        </div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Edit Pengguna</h2>
            <p class="text-xs text-gray-400 font-medium mt-1">Ubah identitas atau role: <span class="text-primary font-bold">{{ $pengguna->name }}</span></p>
        </div>
    </div>

    <form method="POST" action="{{ route('pengguna.update', $pengguna->id) }}" class="space-y-6">
        @csrf @method('PUT')
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2 relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $pengguna->name) }}" required
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $pengguna->email) }}" required
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Role / Otoritas</label>
                    <div class="relative">
                        <select name="role" required
                                class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all appearance-none">
                            <option value="admin" {{ old('role', $pengguna->role) === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="kasir" {{ old('role', $pengguna->role) === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="sm:col-span-2 border-t border-gray-50 pt-4">
                    <p class="text-[10px] font-black text-amber-600 uppercase tracking-widest mb-4">Ganti Kata Sandi (Opsional)</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Sandi Baru</label>
                            <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                        </div>

                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi sandi baru"
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                        </div>
                    </div>
                </div>

                <div class="sm:col-span-2 bg-gray-50 rounded-2xl px-6 py-4 flex items-center justify-between border border-gray-100 mt-2">
                    <div>
                        <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Status Akses</p>
                        <p class="text-xs text-gray-600 font-bold mt-0.5">Nonaktifkan untuk memblokir akses login.</p>
                    </div>
                    <div class="flex items-center">
                        <input type="hidden" name="is_active" value="{{ $pengguna->is_active ? '1' : '0' }}" id="is_active_input">
                        <button type="button" onclick="toggleActive()" id="active_btn"
                                class="relative inline-flex h-7 w-12 rounded-full transition-colors duration-200 ease-in-out focus:outline-none shadow-inner {{ $pengguna->is_active ? 'bg-green-500' : 'bg-gray-200' }}">
                            <span id="active_dot" class="inline-block h-5 w-5 transform rounded-full bg-white shadow-md transition duration-200 ease-in-out mt-1 ml-1 {{ $pengguna->is_active ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('pengguna.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
            <button type="submit" class="px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 transition-all">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

<script>
function toggleActive() {
    const input = document.getElementById('is_active_input');
    const btn = document.getElementById('active_btn');
    const dot = document.getElementById('active_dot');
    
    if (input.value === '1') {
        input.value = '0';
        btn.classList.remove('bg-green-500');
        btn.classList.add('bg-gray-200');
        dot.classList.remove('translate-x-5');
        dot.classList.add('translate-x-0');
    } else {
        input.value = '1';
        btn.classList.remove('bg-gray-200');
        btn.classList.add('bg-green-500');
        dot.classList.remove('translate-x-0');
        dot.classList.add('translate-x-5');
    }
}
</script>
@endsection
