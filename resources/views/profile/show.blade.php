@extends('layouts.app')
@section('title', 'Kemanan & Profil')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-4 mb-8">
        <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0" style="background: linear-gradient(135deg, #15173D, #2d1b69);">
            <span class="material-symbols-outlined text-white !text-[24px]">manage_accounts</span>
        </div>
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Akun Saya</h2>
            <p class="text-xs text-gray-400 font-medium mt-1">Kelola identitas personal dan keamanan akses Anda.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-8">
        @csrf @method('PUT')

        {{-- Section 1: Profil --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 flex flex-col items-center text-center">
                    <div class="relative group mb-6">
                        <div class="w-24 h-24 rounded-3xl bg-primary flex items-center justify-center text-white text-3xl font-black shadow-xl shadow-primary/20 transition-transform group-hover:scale-105">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-8 h-8 rounded-xl bg-secondary text-white flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="material-symbols-outlined !text-[14px]">verified</span>
                        </div>
                    </div>
                    <h3 class="text-lg font-black text-gray-900">{{ $user->name }}</h3>
                    <p class="text-[10px] font-black text-secondary uppercase tracking-[0.2em] mt-1 bg-secondary/5 px-3 py-1 rounded-full border border-secondary/10">
                        {{ $user->role }}
                    </p>
                    <div class="mt-8 w-full pt-6 border-t border-gray-50 flex flex-col gap-3">
                        <div class="flex items-center gap-3 text-left">
                            <span class="material-symbols-outlined text-gray-300 !text-[18px]">mail</span>
                            <p class="text-xs text-gray-500 font-bold truncate">{{ $user->email }}</p>
                        </div>
                        <div class="flex items-center gap-3 text-left">
                            <span class="material-symbols-outlined text-gray-300 !text-[18px]">phone</span>
                            <p class="text-xs text-gray-500 font-bold">{{ $user->phone ?: 'Tidak ada nomor' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
                    <h4 class="text-[10px] font-black text-gray-400 uppercase tracking-widest border-b border-gray-50 pb-4 mb-2">Identitas Dasar</h4>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2 relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nama Tampilan</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                        </div>
                        
                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Email Login</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                        </div>
                        
                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100 space-y-6">
                    <h4 class="text-[10px] font-black text-amber-600 uppercase tracking-widest border-b border-amber-50 pb-4 mb-2">Perbarui Keamanan</h4>
                    
                    <div class="grid grid-cols-1 gap-6">
                        <div class="relative group">
                            <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Kata Sandi Saat Ini</label>
                            <input type="password" name="current_password" placeholder="••••••••"
                                   class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                            @error('current_password') <p class="text-[10px] text-red-500 mt-1 font-black uppercase tracking-wide">{{ $message }}</p> @enderror
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Sandi Baru</label>
                                <input type="password" name="password" placeholder="Min. 8 karakter"
                                       class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                            </div>
                            <div class="relative group">
                                <label class="block text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 ml-1">Konfirmasi Sandi</label>
                                <input type="password" name="password_confirmation" placeholder="Ulangi sandi"
                                       class="w-full bg-gray-50 border border-transparent text-gray-900 rounded-2xl px-5 py-3.5 text-sm font-bold focus:outline-none focus:bg-white focus:border-primary transition-all">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-4 pt-4">
                    <button type="submit" class="px-10 py-4 bg-primary text-white text-xs font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-primary/20 hover:shadow-primary/30 hover:scale-105 active:scale-95 transition-all">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
