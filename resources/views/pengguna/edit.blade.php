@extends('layouts.app')
@section('title', 'Koreksi Profil Pengguna')
@section('page-title', 'Modifikasi Akses')

@section('content')
<div class="max-w-5xl mx-auto py-6" x-data="{ 
    role: '{{ old('role', $pengguna->role) }}',
    isActive: {{ old('is_active', $pengguna->is_active ? 'true' : 'false') }}
}">

    <div class="flex items-center justify-between pb-6 mb-8 border-b border-gray-200">
        <div>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight">Koreksi Otoritas</h2>
            <p class="text-sm text-gray-500 font-medium mt-1">Perbarui hak akses atau rincian administratif: <span class="text-primary font-bold">{{ $pengguna->name }}</span></p>
        </div>
        <a href="{{ route('pengguna.index') }}" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 bg-white hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-lg shadow-sm ring-1 ring-inset ring-gray-300 transition-all">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali
        </a>
    </div>

    <form method="POST" action="{{ route('pengguna.update', $pengguna->id) }}" class="space-y-10">
        @csrf @method('PUT')

        {{-- Section 1: Profil --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Data Personal</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Informasi identitas dasar pengguna yang digunakan untuk kepentingan audit sistem.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="name" value="{{ old('name', $pengguna->name) }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Alamat Email <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', $pengguna->email) }}" required
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Nomor Telepon</label>
                            <input type="text" name="phone" value="{{ old('phone', $pengguna->phone) }}"
                                   class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 placeholder-gray-400 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 2: Otoritas --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Level Akses</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Pengaturan lapisan keamanan sistem. Berhati-hatilah saat mengubah status akses pengguna.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8 space-y-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="sm:col-span-2 relative">
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Atribusi Peran Pengguna <span class="text-red-500">*</span></label>
                            <select name="role" required x-model="role"
                                    class="w-full bg-gray-50/50 border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-semibold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary focus:bg-white transition-colors appearance-none">
                                <option value="kasir">Kasir / Operator (Terbatas)</option>
                                <option value="admin">Administrator (Kepala/Owner)</option>
                            </select>
                            <svg class="absolute right-4 top-10 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50/80 rounded-lg p-5 border border-gray-100 flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-bold text-gray-900">Status Akses Akun</h4>
                            <p class="text-xs text-gray-500 mt-1" :class="!isActive ? 'text-red-500 font-bold' : ''">
                                <span x-show="isActive">Akses saat ini diizinkan (Aktif).</span>
                                <span x-show="!isActive" x-cloak>Akses masuk dibekukan (Suspended).</span>
                            </p>
                        </div>
                        
                        <input type="hidden" name="is_active" :value="isActive ? '1' : '0'">
                        <button type="button" 
                                @click="isActive = !isActive"
                                class="relative inline-flex h-7 w-12 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2"
                                :class="isActive ? 'bg-secondary' : 'bg-gray-300'"
                                role="switch" :aria-checked="isActive.toString()">
                            <span class="pointer-events-none inline-block h-6 w-6 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
                                  :class="isActive ? 'translate-x-5' : 'translate-x-0'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-gray-200"></div>

        {{-- Section 3: Keamanan --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-4">
                <h3 class="text-lg font-bold text-gray-900">Pembaruan Keamanan</h3>
                <p class="text-sm text-gray-500 mt-2 leading-relaxed">Biarkan kosong jika tidak ingin mengganti kata sandi pengguna ini.</p>
            </div>
            
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-sm ring-1 ring-gray-900/5 p-6 sm:p-8">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Kata Sandi Baru <span class="text-gray-400 font-normal normal-case">(Opsional)</span></label>
                            <input type="password" name="password" minlength="8"
                                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="••••••••">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation"
                                   class="w-full bg-white border border-gray-300 text-gray-900 rounded-lg px-4 py-3 text-sm font-bold focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors"
                                   placeholder="••••••••">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-8 mb-4 border-t border-gray-200 flex justify-end items-center gap-4">
            <a href="{{ route('pengguna.index') }}" class="text-sm font-bold text-gray-500 hover:text-gray-900 transition-colors">Batal</a>
            <button type="submit" class="px-8 py-3 bg-gradient-to-r from-primary to-[#2a2c5a] hover:from-[#0c0d24] hover:to-[#1a1b3c] text-white text-sm font-bold tracking-wider uppercase rounded-lg shadow-md hover:shadow-lg transition-all focus:ring-2 focus:ring-offset-2 focus:ring-primary inline-flex items-center gap-2">
                Simpan Perubahan
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
        </div>

    </form>
</div>
@endsection
