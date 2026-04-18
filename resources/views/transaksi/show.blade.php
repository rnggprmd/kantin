@extends('layouts.app')
@section('title', 'Detail Transaksi ' . $transaksi->kode_transaksi)
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="max-w-2xl mx-auto space-y-5">

    <div class="flex items-center gap-3">
        <a href="{{ route('transaksi.index') }}" class="text-gray-500 hover:text-primary transition-colors flex items-center justify-center w-8 h-8 rounded-md hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <h2 class="text-primary font-bold text-xl">Struk Transaksi</h2>
    </div>

    {{-- Struk --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden shadow-sm">

        {{-- Header Struk --}}
        <div class="bg-primary px-6 py-6 border-b border-primary text-center">
            <p class="text-white font-bold text-xl tracking-tight">Kantin <span class="text-tertiary">Maria</span></p>
            <p class="text-gray-300 text-xs mt-0.5">Sistem Manajemen Kantin</p>
            <div class="mt-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white text-primary text-xs font-bold uppercase tracking-wider shadow-sm">
                    {{ $transaksi->status }}
                </span>
            </div>
        </div>

        <div class="px-6 py-6 space-y-5">
            {{-- Info --}}
            <div class="grid grid-cols-2 gap-4 text-sm bg-gray-50 p-4 rounded-md border border-gray-100">
                <div>
                    <p class="text-gray-500 text-xs mb-1">Kode Transaksi</p>
                    <p class="text-primary border border-gray-200 bg-white inline-block px-2 py-0.5 rounded text-xs font-mono font-bold">{{ $transaksi->kode_transaksi }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs mb-1">Tanggal</p>
                    <p class="text-gray-900 font-medium">{{ $transaksi->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs mb-1">Metode Bayar</p>
                    <p class="text-gray-900 font-medium uppercase">{{ str_replace('_', ' ', $transaksi->metode_bayar) }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs mb-1">Pelanggan</p>
                    <p class="text-gray-900 font-medium">{{ $transaksi->pelanggan_nama ?: '-' }}</p>
                </div>
            </div>

            {{-- Items --}}
            <div>
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Rincian Pembelian</h4>
                <div class="space-y-3">
                    @foreach($transaksi->details as $detail)
                    <div class="flex items-start justify-between gap-3 text-sm">
                        <div class="flex-1">
                            <p class="text-gray-900 font-medium">{{ $detail->nama_menu }}</p>
                            <p class="text-gray-500 text-xs mt-0.5">
                                {{ $detail->qty }} × Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                            </p>
                        </div>
                        <p class="text-gray-900 font-semibold shrink-0">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-dashed border-gray-300"></div>

            {{-- Total --}}
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Subtotal</span>
                    <span class="text-gray-900 font-medium">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
                @if($transaksi->metode_bayar === 'tunai')
                <div class="flex justify-between text-sm items-center">
                    <span class="text-gray-500">Uang Bayar</span>
                    <span class="text-gray-900 font-medium border border-gray-200 px-2 py-0.5 rounded bg-gray-50">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kembalian</span>
                    <span class="text-green-600 font-bold">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="flex justify-between pt-3 border-t border-gray-200 mt-2">
                    <span class="text-gray-900 font-bold uppercase tracking-wider">TOTAL TAGIHAN</span>
                    <span class="text-xl font-bold text-secondary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($transaksi->catatan)
            <div class="bg-amber-50 border border-amber-100 rounded-md px-4 py-3 text-sm text-gray-700">
                <p class="text-[10px] font-bold text-amber-600 uppercase tracking-wider mb-1">Catatan Tambahan:</p>
                <p class="italic text-gray-600">"{{ $transaksi->catatan }}"</p>
            </div>
            @endif
        </div>

        {{-- Footer Struk --}}
        <div class="border-t border-gray-100 bg-gray-50 px-6 py-4 text-center text-xs text-gray-500 font-medium">
            Tanda terima ini merupakan bukti transaksi yang sah. <br> Terima kasih telah berbelanja 🙏
        </div>
    </div>

    @if($transaksi->status === 'pending' && $transaksi->metode_bayar === 'non_tunai' && $transaksi->catatan)
    <div class="px-6 py-6 border border-amber-200 bg-amber-50 rounded-lg shadow-sm">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 text-center sm:text-left">
            <div>
                <h4 class="text-amber-800 font-bold">Pembayaran Menunggu Penyelesaian</h4>
                <p class="text-amber-700 text-xs mt-1">Silakan selesaikan pembayaran non-tunai melalui portal Midtrans.</p>
            </div>
            <button id="pay-button" class="px-8 py-3 bg-primary text-white font-bold rounded-lg shadow-md hover:bg-[#0c0d24] transition-all flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                Bayar Sekarang
            </button>
        </div>
    </div>
    @endif

    {{-- Actions --}}
    <div class="flex gap-3 pt-4">
        <a href="{{ route('transaksi.create') }}"
           class="flex-1 flex items-center justify-center gap-2 py-3 bg-secondary hover:opacity-90 text-white text-sm font-bold rounded-xl shadow-md transition-all border border-transparent">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Buat Transaksi Baru
        </a>
        <button onclick="window.print()" class="flex-none px-6 flex items-center justify-center gap-2 py-3 bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 text-sm font-bold rounded-xl shadow-sm transition-all">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
            </svg>
            Cetak
        </button>
    </div>
</div>

@if($transaksi->status === 'pending' && $transaksi->metode_bayar === 'non_tunai' && $transaksi->catatan)
@push('scripts')
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $transaksi->catatan }}', {
            onSuccess: function(result){
                alert("Pembayaran berhasil!");
                location.reload();
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
