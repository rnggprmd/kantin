@extends('layouts.app')
@section('title', 'Detail Transaksi ' . $transaksi->kode_transaksi)
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-6 max-w-7xl mx-auto">
    
    {{-- Left Column: Struk --}}
    <div class="lg:col-span-8 space-y-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-primary transition-colors flex items-center justify-center w-8 h-8 rounded-md hover:bg-gray-100">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h2 class="text-primary font-bold text-xl uppercase tracking-tight">Struk Transaksi</h2>
        </div>

        <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
            {{-- Header Struk --}}
            <div class="bg-primary px-8 py-10 border-b border-primary text-center relative overflow-hidden">
                {{-- Decorative circles --}}
                <div class="absolute -top-10 -left-10 w-32 h-32 bg-white/5 rounded-full"></div>
                <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-white/5 rounded-full"></div>
                
                <p class="text-white font-black text-2xl tracking-tighter relative z-10">Kantin <span class="text-tertiary">Maria</span></p>
                <p class="text-tertiary/60 text-[11px] font-bold uppercase tracking-[0.2em] mt-1 relative z-10">Sistem Manajemen Kantin</p>
                <div class="mt-6 relative z-10">
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white text-primary text-[11px] font-black uppercase tracking-widest shadow-lg">
                        <span class="w-2 h-2 rounded-full {{ $transaksi->status === 'selesai' ? 'bg-green-500' : ($transaksi->status === 'batal' ? 'bg-red-500' : 'bg-amber-500 animate-pulse') }}"></span>
                        {{ $transaksi->status }}
                    </span>
                </div>
            </div>

            <div class="px-8 py-8 space-y-8">
                {{-- Items --}}
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Rincian Pembelian</h4>
                        <div class="h-px bg-gray-100 grow"></div>
                    </div>
                    <div class="space-y-4">
                        @foreach($transaksi->details as $detail)
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-bold text-gray-900 truncate">{{ $detail->nama_menu }}</p>
                                <p class="text-[11px] font-bold text-gray-400 mt-0.5">
                                    {{ $detail->qty }} × <span class="text-gray-500 font-medium">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</span>
                                </p>
                            </div>
                            <p class="text-sm font-black text-gray-900 shrink-0">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="border-t border-dashed border-gray-200"></div>

                {{-- Total Section --}}
                <div class="bg-gray-50/50 rounded-xl p-6 space-y-3">
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-gray-400 uppercase tracking-wider">Subtotal</span>
                        <span class="text-gray-900">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                    
                    @if($transaksi->metode_bayar === 'tunai')
                    <div class="flex justify-between text-xs font-bold items-center">
                        <span class="text-gray-400 uppercase tracking-wider">Bayar Tunai</span>
                        <span class="text-gray-900">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-xs font-bold">
                        <span class="text-gray-400 uppercase tracking-wider">Kembalian</span>
                        <span class="text-green-600">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                    </div>
                    @endif

                    <div class="border-t border-gray-200 pt-3 flex justify-between items-center">
                        <span class="text-[11px] font-black text-gray-900 uppercase tracking-[0.2em]">Total Akhir</span>
                        <span class="text-2xl font-black text-secondary tracking-tighter">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                    </div>
                </div>

                @if($transaksi->catatan)
                <div class="relative overflow-hidden group">
                    <div class="absolute inset-0 bg-blue-50/50 rounded-xl transition-colors group-hover:bg-blue-50"></div>
                    <div class="relative px-5 py-4 flex gap-3 text-xs">
                        <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <div>
                            <p class="font-black text-blue-900 uppercase tracking-wider mb-1">Catatan</p>
                            <p class="text-blue-700 italic font-medium leading-relaxed">"{{ $transaksi->catatan }}"</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="bg-gray-50 border-t border-gray-100 px-8 py-5 text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">Terima Kasih — Kantin Maria</p>
            </div>
        </div>
    </div>

    {{-- Right Column: Summary & Actions --}}
    <div class="lg:col-span-4 space-y-6">
        {{-- Summary Card --}}
        <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm space-y-6">
            <h4 class="text-[11px] font-black text-gray-400 uppercase tracking-[0.2em]">Informasi Transaksi</h4>
            
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-4m0 0l4-4m-4 4l-4-4m4 4l4 4M3 8V4m0 0h4M3 4l4 4m14 0V4m0 0h-4m4 0l-4 4m0 12v4m0 0h4m-4 0l4-4m-12 0v4m0 0h-4m4 0l-4-4"/></svg>
                    </div>
                    <div class="min-w-0">
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">ID Pesanan</p>
                        <p class="text-sm font-black text-gray-900 truncate font-mono tracking-tight">{{ $transaksi->kode_transaksi }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Waktu Transaksi</p>
                        <p class="text-sm font-black text-gray-900">{{ $transaksi->created_at->format('d/m/Y H:i') }} WIB</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a2 2 0 002-2V5a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Metode Pembayaran</p>
                        <p class="text-sm font-black text-gray-900 uppercase tracking-tight">{{ str_replace('_', ' ', $transaksi->metode_bayar) }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Nama Pelanggan</p>
                        <p class="text-sm font-black text-gray-900 capitalize">{{ $transaksi->pelanggan_nama ?: 'Umum / Guest' }}</p>
                    </div>
                </div>
            </div>

            @if($transaksi->status === 'pending' && $transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token)
            <div class="pt-4 border-t border-gray-100">
                <button id="pay-button" class="w-full py-4 bg-primary text-white font-black text-sm uppercase tracking-widest rounded-xl shadow-lg hover:shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center justify-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    Bayar Sekarang
                </button>
            </div>
            @endif
        </div>

        {{-- Actions Card --}}
        <div class="space-y-3">
            <button onclick="window.print()" class="w-full h-14 bg-white border border-gray-200 hover:bg-gray-50 text-gray-900 font-black text-xs uppercase tracking-widest rounded-xl shadow-sm transition-all flex items-center justify-center gap-3">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Cetak Struk
            </button>
            
            <a href="{{ route('transaksi.create') }}" class="w-full h-14 bg-secondary text-white font-black text-xs uppercase tracking-widest rounded-xl shadow-lg shadow-secondary/20 hover:shadow-secondary/30 transition-all flex items-center justify-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Transaksi Baru
            </a>
        </div>
    </div>
</div>

@if($transaksi->status === 'pending' && $transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token)
@push('scripts')
<script src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaksi->snap_token }}', {
            onSuccess: function(result){
                // Notify server to update status to 'selesai'
                fetch('{{ route('transaksi.mark-as-success', $transaksi->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).then(() => {
                    window.location.href = '{{ route('transaksi.index') }}';
                });
            },
            onPending: function(result){
                alert("Menunggu pembayaran...");
            },
            onError: function(result){
                alert("Pembayaran gagal!");
            }
        });
    };
</script>
@endpush
@endif
@endsection
