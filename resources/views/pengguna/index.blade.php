@extends('layouts.app')
@section('title', 'Otorisasi Pengguna')
@section('page-title', 'Otorisasi Pengguna')

@section('content')
<div class="h-full flex flex-col space-y-4">

    {{-- Top Action Bar (Professional Card Style) --}}
    <div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mb-2">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-4 border-b border-gray-200">
            <div>
                <h2 class="text-xl font-bold text-gray-900 tracking-tight">Manajemen Pengguna</h2>
                <p class="text-xs text-gray-500 font-medium">Pemeliharaan izin akses dan otoritas personel operasional.</p>
            </div>
            <a href="{{ route('pengguna.create') }}" class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-primary hover:bg-[#0c0d24] text-white text-sm font-semibold rounded-md shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Registrasi Karyawan
            </a>
        </div>
        
        {{-- Integrated Filter Bar with Auto-Submit --}}
        <div class="px-4 py-3 bg-gray-50/50">
            <form method="GET" x-data x-ref="penggunaForm" class="flex flex-col sm:flex-row items-center gap-3">
                {{-- Search Input --}}
                <div class="flex-1 relative w-full">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           @input.debounce.500ms="$refs.penggunaForm.submit()"
                           placeholder="Cari nama, email, atau nomor telepon..."
                           class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors">
                </div>

                {{-- Role Filter --}}
                <div class="w-full sm:w-56">
                    <select name="role" class="w-full bg-white border border-gray-300 text-gray-700 rounded-md px-3 py-1.5 text-sm focus:outline-none focus:border-primary focus:ring-1 focus:ring-primary transition-colors" onchange="this.form.submit()">
                        <option value="">Semua Peran (Roles)</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator (Penuh)</option>
                        <option value="kasir" {{ request('role') === 'kasir' ? 'selected' : '' }}>Kasir / Sales (Terbatas)</option>
                    </select>
                </div>

                {{-- Reset Button --}}
                @if(request('search') || request('role'))
                <a href="{{ route('pengguna.index') }}" class="w-full sm:w-auto px-4 py-1.5 bg-gray-100 text-gray-600 text-xs font-bold rounded-md hover:bg-gray-200 transition-colors border border-gray-200 text-center shadow-sm">
                    Hapus Filter
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- Table Container --}}
    <div class="bg-white border border-gray-200 rounded-lg flex-1 overflow-hidden shadow-sm">
        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50/80 border-b border-gray-200 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                    <tr>
                        <th class="px-5 py-4 w-12 text-center">No</th>
                        <th class="px-5 py-4">Identitas Pegawai</th>
                        <th class="px-5 py-4">Otoritas</th>
                        <th class="px-5 py-4 text-center">Status Akses</th>
                        <th class="px-5 py-4">Bergabung</th>
                        <th class="px-5 py-4 text-right w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-medium">
                    @forelse($penggunas as $p)
                    <tr class="hover:bg-gray-50/50 transition-colors text-gray-800">
                        <td class="px-5 py-3.5 text-center text-gray-500 font-semibold">
                            {{ ($penggunas->currentPage() - 1) * $penggunas->perPage() + $loop->iteration }}
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded shrink-0 bg-gray-100 border border-gray-200 flex items-center justify-center text-xs font-black text-gray-500">
                                    {{ strtoupper(substr($p->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-[13px] text-gray-900 font-bold truncate tracking-tight">{{ $p->name }}
                                        @if($p->id === auth()->id())
                                        <span class="text-[9px] text-primary font-bold uppercase tracking-wider ml-1">(SAYA)</span>
                                        @endif
                                    </p>
                                    <p class="text-[11px] text-gray-400 font-normal truncate">{{ $p->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-3.5">
                            <span class="text-[11px] font-black uppercase tracking-widest {{ $p->role === 'admin' ? 'text-primary' : 'text-gray-500' }}">
                                {{ $p->role }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-center">
                            @if($p->is_active)
                            <span class="text-green-600 font-black text-[11px] uppercase tracking-wider">Aktif</span>
                            @else
                            <span class="text-red-500 font-black text-[11px] uppercase tracking-wider">Terblokir</span>
                            @endif
                        </td>
                        <td class="px-5 py-3.5 text-gray-400 text-[11px] font-normal tracking-tight">
                            {{ $p->created_at->format('d/m/Y') }}
                        </td>
                        <td class="px-5 py-3.5 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('pengguna.edit', $p->id) }}"
                                   class="p-1.5 text-gray-500 hover:text-primary hover:bg-gray-100 rounded-md transition-all" title="Modifikasi Akses">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                @if($p->id !== auth()->id())
                                <button type="button" 
                                        @click="$dispatch('confirm', { 
                                            title: 'Terminasi Hak Akses?', 
                                            message: 'Apakah Anda yakin ingin mencabut seluruh otoritas akses untuk {{ $p->name }}? Pengguna ini tidak akan bisa login lagi.', 
                                            action: '{{ route('pengguna.destroy', $p->id) }}',
                                            method: 'DELETE',
                                            confirmText: 'Ya, Terminasi'
                                        })"
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-md transition-all" title="Terminasi Hak Akses">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-16 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                            <p class="text-sm font-semibold text-gray-500 mb-1">Daftar Karyawan Kosong</p>
                            <p class="text-[11px] font-medium text-gray-400">Belum ada akun pegawai yang terdaftar di sistem.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($penggunas->hasPages())
        <div class="px-4 py-3 border-t border-gray-200 bg-white">
            {{ $penggunas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
