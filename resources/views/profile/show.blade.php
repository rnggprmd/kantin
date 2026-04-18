@extends('layouts.app')
@section('title', 'Kemanan & Profil')
@section('page-title', 'Pengaturan Akun')

@section('content')
<div class="max-w-5xl mx-auto py-6">

    <div class="flex items-center justify-between pb-6 mb-8 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Akun Saya</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Kelola informasi identitas personal dan tingkat keamanan akses Anda.</p>
        </div>
    </div>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-10">
        @csrf @method('PUT')

        {{-- Section 1: Profil --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Identitas Dasar</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Informasi ini akan muncul di setiap nota transaksi dan laporan yang Anda tangani.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                             <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                                <div class="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white text-2xl font-black shadow-inner">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="text-lg font-extrabold text-gray-900">{{ $user->name }}</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary/10 text-secondary uppercase tracking-widest border border-secondary/20 mt-1">
                                        {{ $user->role }}
                                    </span>
                                </div>
                            </div>

                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap Tampilan <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Email Login <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor Telepon Personal</label>
                            <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 2: Keamanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Perbarui Kredensial</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Ubah kata sandi secara berkala untuk menjaga keamanan terminal kasir Anda. Biarkan kosong jika tidak ingin mengubahnya.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8 space-y-6">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kata Sandi Saat Ini <span class="text-gray-400 font-normal normal-case">(Diperlukan jika mengganti sandi baru)</span></label>
                        <input type="password" name="current_password"
                               class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors"
                               placeholder="••••••••">
                        @error('current_password') <p class="text-xs text-red-600 mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 pt-4 border-t border-gray-100">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kata Sandi Baru</label>
                            <input type="password" name="password" minlength="8"
                                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="Min. 8 karakter">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="Ketik ulang sandi">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 mb-4 border-t border-gray-200 flex justify-end items-center gap-4">
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-[#2a2c5a] hover:from-[#0c0d24] hover:to-[#1a1b3c] text-white text-sm font-bold tracking-wider uppercase rounded-lg shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-primary inline-flex items-center gap-2">
                Simpan Perubahan Akun
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </form>
</div>
@endsection
