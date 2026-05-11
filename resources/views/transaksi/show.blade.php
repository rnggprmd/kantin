@extends('layouts.app')
@section('title', 'Nota ' . $transaksi->kode_transaksi)
@section('page-title', 'Detail Transaksi')

@section('content')
<div class="space-y-8">
    
    {{-- Unified Header Navigation Card --}}
    <div class="bg-white rounded-[2rem] border border-gray-200 shadow-sm p-4 lg:p-5">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="flex items-center gap-5">
                <a href="{{ route('transaksi.index') }}" 
                   class="flex items-center justify-center w-12 h-12 rounded-2xl bg-gray-50 text-gray-400 hover:text-primary hover:bg-gray-100 transition-all border border-gray-100 shrink-0">
                    <span class="material-symbols-outlined !text-[22px]">arrow_back</span>
                </a>
                <div class="space-y-1">
                    <div class="flex items-center gap-3">
                        <h2 class="text-xl font-black text-gray-900 tracking-tighter">{{ $transaksi->kode_transaksi }}</h2>
                        @if($transaksi->status === 'selesai')
                            <span class="px-2.5 py-0.5 rounded-full bg-green-500 text-white text-[9px] font-black uppercase tracking-widest">Lunas</span>
                        @elseif($transaksi->status === 'pending')
                            <span class="px-2.5 py-0.5 rounded-full bg-amber-500 text-white text-[9px] font-black uppercase tracking-widest">Pending</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-full bg-red-500 text-white text-[9px] font-black uppercase tracking-widest">Batal</span>
                        @endif
                    </div>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1.5">
                        <span class="material-symbols-outlined !text-[12px]">schedule</span>
                        {{ $transaksi->created_at->translatedFormat('d F Y, H:i') }}
                    </p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('transaksi.pdf', $transaksi->id) }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 bg-white border border-gray-200 text-gray-700 text-[10px] font-black rounded-xl hover:bg-gray-50 transition-all uppercase tracking-widest shadow-sm">
                    <span class="material-symbols-outlined !text-[18px]">picture_as_pdf</span>
                    Unduh PDF
                </a>
                
                @if($transaksi->status === 'pending' && $transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token)
                <button id="pay-button" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-6 py-3 bg-secondary text-white text-[10px] font-black rounded-xl hover:opacity-90 transition-all uppercase tracking-widest shadow-lg shadow-secondary/10 animate-pulse">
                    <span class="material-symbols-outlined !text-[18px]">payments</span>
                    Bayar Sekarang
                </button>
                @endif

                <a href="{{ route('transaksi.create') }}" class="flex-1 md:flex-none flex items-center justify-center gap-2 px-5 py-3 bg-primary text-white text-[10px] font-black rounded-xl hover:opacity-90 transition-all uppercase tracking-widest shadow-lg shadow-primary/10">
                    <span class="material-symbols-outlined !text-[18px]">add</span>
                    Baru
                </a>
            </div>
        </div>
    </div>

    {{-- Main Statement Container --}}
    <div class="bg-white rounded-[2.5rem] border border-gray-200 shadow-sm overflow-hidden mb-12">
        
        {{-- Branding & Stamp --}}
        <div class="p-8 lg:p-12 border-b border-gray-100 bg-gray-50/30 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-primary/5 rounded-full -mr-32 -mt-32 blur-3xl opacity-50"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8 relative z-10">
                <div class="space-y-4">
                    <div class="w-14 h-14 rounded-2xl bg-primary flex items-center justify-center shadow-xl shadow-primary/20">
                        <span class="material-symbols-outlined text-white !text-[28px]">restaurant</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-black text-gray-900 tracking-tighter">Kantin <span class="text-secondary">Maria</span></h3>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.4em] mt-1">Premium Food & Services</p>
                    </div>
                </div>

                @if($transaksi->status === 'selesai')
                <div class="transform rotate-[-8deg] border-4 border-green-500/20 rounded-2xl px-6 py-2">
                    <p class="text-2xl font-black text-green-500/30 uppercase tracking-[0.2em]">SUDAH LUNAS</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Meta Info Grid --}}
        <div class="grid grid-cols-2 md:grid-cols-4 border-b border-gray-100 bg-white">
            <div class="p-6 border-r border-gray-100">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Pelanggan</p>
                <p class="text-sm font-black text-gray-900">{{ $transaksi->pelanggan_nama ?: 'Umum' }}</p>
            </div>
            <div class="p-6 border-r border-gray-100">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Mode Bayar</p>
                <p class="text-sm font-black text-secondary uppercase tracking-tighter">{{ str_replace('_', ' ', $transaksi->metode_bayar) }}</p>
            </div>
            <div class="p-6 border-r border-gray-100">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">Operator</p>
                <p class="text-sm font-black text-gray-900 truncate">{{ $transaksi->user?->name ?? 'Sistem' }}</p>
            </div>
            <div class="p-6">
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-1.5">ID Referensi</p>
                <p class="text-sm font-black text-gray-900 font-mono tracking-tighter uppercase">{{ substr($transaksi->kode_transaksi, -8) }}</p>
            </div>
        </div>

        {{-- Items Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em] border-b border-gray-50 bg-gray-50/50">
                        <th class="px-10 py-5">Pesanan Item</th>
                        <th class="px-4 py-5 text-center">Jumlah</th>
                        <th class="px-4 py-5 text-right">Harga</th>
                        <th class="px-10 py-5 text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($transaksi->details as $detail)
                    <tr class="group hover:bg-gray-50/50 transition-colors">
                        <td class="px-10 py-6">
                            <p class="text-sm font-black text-gray-800 tracking-tight">{{ $detail->nama_menu }}</p>
                        </td>
                        <td class="px-4 py-6 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-gray-100 text-xs font-black text-gray-600">{{ $detail->qty }}</span>
                        </td>
                        <td class="px-4 py-6 text-right text-[11px] font-bold text-gray-400 tabular-nums">
                            Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}
                        </td>
                        <td class="px-10 py-6 text-right text-sm font-black text-gray-900 tabular-nums">
                            Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Footer Summary --}}
        <div class="p-10 bg-gray-900 flex flex-col md:flex-row justify-between items-start gap-12 relative overflow-hidden">
            {{-- Decorative pattern for footer --}}
            <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none" style="background-image: url('data:image/svg+xml,%3Csvg width=\"40\" height=\"40\" viewBox=\"0 0 40 40\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M0 0h20v20H0V0zm20 20h20v20H20V20z\" fill=\"%23ffffff\" fill-opacity=\"1\" fill-rule=\"evenodd\"/%3E%3C/svg%3E');"></div>

            {{-- LEFT: Billing & Audit --}}
            <div class="flex-1 space-y-8 relative z-10">
                <div class="grid grid-cols-2 gap-8">
                    <div>
                        <h4 class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-3">Informasi Penagihan</h4>
                        <div class="space-y-2">
                            <p class="text-xs text-white/70 font-black tracking-tight">{{ $transaksi->pelanggan_nama ?: 'Pelanggan Umum' }}</p>
                            <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest">ID: {{ substr($transaksi->kode_transaksi, -8) }}</p>
                        </div>
                    </div>
                    <div>
                        <h4 class="text-[9px] font-black text-white/30 uppercase tracking-[0.2em] mb-3">Otorisasi Kasir</h4>
                        <div class="space-y-2">
                            <p class="text-xs text-white/70 font-black tracking-tight">{{ $transaksi->user?->name ?? 'Sistem' }}</p>
                            <p class="text-[10px] text-white/40 font-bold uppercase tracking-widest">{{ $transaksi->created_at->format('H:i:s') }} WIB</p>
                        </div>
                    </div>
                </div>

                @if($transaksi->catatan && $transaksi->catatan !== '-')
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10">
                    <p class="text-[9px] font-black text-white/30 uppercase tracking-widest mb-1.5">Catatan Pesanan:</p>
                    <p class="text-xs text-white/60 font-medium italic">"{{ $transaksi->catatan }}"</p>
                </div>
                @endif
                
                {{-- Horizontal Timeline --}}
                <div class="flex items-center gap-6 pt-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-primary shadow-[0_0_8px_rgba(21,23,61,1)]"></div>
                        <span class="text-[9px] font-black text-white/40 uppercase tracking-widest">Ordered</span>
                    </div>
                    <div class="w-8 h-[1px] bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $transaksi->status === 'selesai' ? 'bg-secondary' : 'bg-white/10' }}"></div>
                        <span class="text-[9px] font-black text-white/40 uppercase tracking-widest">Paid</span>
                    </div>
                    <div class="w-8 h-[1px] bg-white/10"></div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full {{ $transaksi->status === 'selesai' ? 'bg-green-500' : 'bg-white/10' }}"></div>
                        <span class="text-[9px] font-black text-white/40 uppercase tracking-widest">Closed</span>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Totals --}}
            <div class="w-full md:w-auto text-right relative z-10">
                <div class="mb-8">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-green-500/10 border border-green-500/20 text-green-500 mb-4">
                        <span class="material-symbols-outlined !text-[14px]">verified</span>
                        <span class="text-[9px] font-black uppercase tracking-widest">Verified Transaction</span>
                    </div>
                    <p class="text-[10px] font-black text-white/30 uppercase tracking-[0.3em] mb-2">Total Penjualan Net</p>
                    <p class="text-6xl font-black text-white tracking-tighter tabular-nums leading-none">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</p>
                </div>
                
                @if($transaksi->metode_bayar === 'tunai')
                <div class="space-y-2 pt-6 border-t border-white/5">
                    <div class="flex justify-between items-center gap-8 text-[11px] font-bold text-white/40 uppercase">
                        <span>Tunai Diterima</span>
                        <span class="text-white">Rp {{ number_format($transaksi->uang_bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between items-center gap-8 text-[11px] font-bold text-white/40 uppercase">
                        <span>Sisa Kembali</span>
                        <span class="text-secondary">Rp {{ number_format($transaksi->kembalian, 0, ',', '.') }}</span>
                    </div>
                </div>
                @endif
            </div>
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
                fetch('{{ route('transaksi.mark-as-success', $transaksi->id) }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).then(() => {
                    window.location.reload();
                });
            },
            onPending: function(result){
                window.location.reload();
            },
            onError: function(result){
                window.location.reload();
            },
            onClose: function(){
                // User closed the popup without finishing payment
                window.location.reload();
            }
        });
    };
</script>
@endpush
@endif
@endsection

