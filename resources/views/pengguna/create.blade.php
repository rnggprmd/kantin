@extends('layouts.app')
@section('title', 'Tambah Pengguna')
@section('page-title', 'Registrasi Personel')

@section('content')
<div class="max-w-3xl mx-auto">
    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #2d1b69, #4a1d96);">
            <span class="material-symbols-outlined text-purple-300 !text-[24px]">person_add</span>
        </div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Registrasi Pengguna</h2>
            <p class="text-xs text-gray-400 font-medium mt-1">Buat akun akses untuk personel Admin atau Kasir.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('pengguna.store') }}" class="space-y-6">
        @csrf
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2 relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Ketik nama personel..."
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Role / Otoritas</label>
                    <div class="relative">
                        <select name="role" required
                                class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all appearance-none">
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                            <option value="kasir" {{ old('role') === 'kasir' ? 'selected' : '' }}>Kasir</option>
                        </select>
                        <span class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none">expand_more</span>
                    </div>
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi</label>
                    <input type="password" name="password" required placeholder="Minimal 8 karakter"
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                </div>

                <div class="relative group">
                    <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Sandi</label>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi kata sandi"
                           class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 pt-2">
            <a href="{{ route('pengguna.index') }}" class="text-xs font-black text-gray-400 hover:text-gray-600 uppercase tracking-widest transition-colors">Batal</a>
            <button type="submit" class="px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 transition-all">
                Daftarkan Akun
            </button>
        </div>
    </form>
</div>
@endsection
