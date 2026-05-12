@extends('layouts.app')
@section('title', 'Monitor Dapur')
@section('page-title', 'Dapur — Pesanan Masuk')

@push('styles')
<style>
    .stat-card {
        position: relative;
        overflow: hidden;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .stat-card::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.08) 0%, transparent 60%);
        pointer-events: none;
    }
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 40px -12px rgba(0,0,0,0.2);
    }
    .stat-card .card-glow {
        position: absolute;
        width: 80px;
        height: 80px;
        border-radius: 50%;
        filter: blur(30px);
        opacity: 0.3;
        right: -10px;
        bottom: -10px;
    }
    @keyframes fadeSlideUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-card { animation: fadeSlideUp 0.5s ease both; }
    .anim-card:nth-child(1) { animation-delay: 0.05s; }
    .anim-card:nth-child(2) { animation-delay: 0.10s; }
    .anim-card:nth-child(3) { animation-delay: 0.15s; }
</style>
@endpush

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 p-5">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #15173D, #2d1b69);">
                    <span class="material-symbols-outlined text-white !text-[22px]">soup_kitchen</span>
                </div>
                <div>
                    <h2 class="text-lg font-black text-gray-900 tracking-tight">Sistem Antrean Dapur</h2>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">Pesanan aktif hari ini — refresh otomatis setiap 15 detik.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Stats Bar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        @php
            $menunggu = $pesanans->where('status_pesanan', 'menunggu')->count();
            $diproses = $pesanans->where('status_pesanan', 'diproses')->count();
        @endphp
        
        {{-- Menunggu --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #451a03 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #f59e0b;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.2);">
                    <span class="material-symbols-outlined text-amber-400 !text-[22px]">hourglass_top</span>
                </div>
                <span class="text-[10px] text-amber-300/60 font-black uppercase tracking-widest">Antrean</span>
            </div>
            <p class="text-[11px] text-amber-300/50 uppercase tracking-wider font-bold mb-1">Pesanan Menunggu</p>
            <p class="text-2xl font-black text-white tracking-tight">{{ $menunggu }} <span class="text-sm font-semibold text-white/30">aktif</span></p>
        </div>

        {{-- Diproses --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #1e3a5f 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #3b82f6;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.2);">
                    <span class="material-symbols-outlined text-blue-400 !text-[22px]">soup_kitchen</span>
                </div>
                <span class="text-[10px] text-blue-300/60 font-black uppercase tracking-widest">Dapur</span>
            </div>
            <p class="text-[11px] text-blue-300/50 uppercase tracking-wider font-bold mb-1">Sedang Diproses</p>
            <p class="text-2xl font-black text-white tracking-tight">{{ $diproses }} <span class="text-sm font-semibold text-white/30">aktif</span></p>
        </div>

        {{-- Total --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #064e3b 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #10b981;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.2);">
                    <span class="material-symbols-outlined text-emerald-400 !text-[22px]">receipt_long</span>
                </div>
                <span class="text-[10px] text-emerald-300/60 font-black uppercase tracking-widest">Total</span>
            </div>
            <p class="text-[11px] text-emerald-300/50 uppercase tracking-wider font-bold mb-1">Total Pesanan Aktif</p>
            <p class="text-2xl font-black text-white tracking-tight">{{ $pesanans->count() }} <span class="text-sm font-semibold text-white/30">nota</span></p>
        </div>
    </div>

    {{-- Pesanan Cards --}}
    @if($pesanans->isEmpty())
    <div class="py-24 text-center bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col items-center gap-3">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center" style="background: linear-gradient(135deg, #f0f4ff, #e8ecf8);">
            <span class="material-symbols-outlined text-gray-300 !text-[32px]">task_alt</span>
        </div>
        <div>
            <p class="font-black text-gray-900">Tidak ada pesanan aktif</p>
            <p class="text-xs text-gray-400 mt-1">Semua pesanan sudah selesai diproses!</p>
        </div>
    </div>
    @else
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($pesanans as $p)
        <div class="bg-white rounded-[2rem] border border-gray-200 shadow-sm overflow-hidden" id="card-{{ $p->id }}">
            
            {{-- Card Header --}}
            <div class="px-6 py-5 flex items-start justify-between border-b border-gray-100 bg-gray-50/30">
                <div>
                    <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full mb-3
                        {{ $p->status_pesanan === 'menunggu' ? 'bg-amber-100/50 text-amber-600' : 'bg-blue-100/50 text-blue-600' }}">
                        <span class="text-[10px] font-black uppercase tracking-widest">{{ $p->status_pesanan === 'menunggu' ? 'Menunggu' : 'Diproses' }}</span>
                    </div>
                    <p class="text-3xl font-black text-gray-900 tracking-tight">No. {{ str_pad($p->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-black text-gray-900 bg-gray-100/80 px-3 py-1 rounded-lg inline-block mb-1">{{ $p->pelanggan_nama }}</p>
                    <p class="text-[11px] text-gray-400 font-bold block">{{ $p->meja?->nama ?? 'Pesan Langsung' }}</p>
                    <p class="text-[10px] text-gray-300 font-bold mt-0.5">{{ $p->created_at->format('H:i') }}</p>
                </div>
            </div>

            {{-- Item List --}}
            <div class="px-6 py-5 space-y-3 bg-white">
                @foreach($p->details as $d)
                <div class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 bg-primary/5 text-primary text-xs font-black rounded-xl flex items-center justify-center border border-primary/10">{{ $d->qty }}×</span>
                        <span class="text-sm font-bold text-gray-800">{{ $d->nama_menu }}</span>
                    </div>
                    <span class="text-xs font-black text-gray-400">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</span>
                </div>
                @endforeach
                <div class="border-t border-gray-100 pt-4 mt-4 flex justify-between items-center text-sm font-black text-primary">
                    <span class="uppercase tracking-widest text-[11px]">Total Tagihan</span>
                    <span class="text-sm font-bold">Rp {{ number_format($p->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="px-6 pb-6 bg-white flex gap-3">
                @if($p->status_pesanan === 'menunggu')
                <button onclick="updateStatus({{ $p->id }}, 'diproses')"
                    class="flex-1 py-3 bg-primary text-white text-[10px] font-black rounded-xl hover:opacity-90 transition-all uppercase tracking-widest shadow-lg shadow-primary/10">
                    Mulai Proses
                </button>
                @endif
                @if($p->status_pesanan === 'diproses')
                <button onclick="updateStatus({{ $p->id }}, 'siap')"
                    class="flex-1 py-3 bg-green-500 text-white text-[10px] font-black rounded-xl hover:opacity-90 transition-all uppercase tracking-widest shadow-lg shadow-green-500/10">
                    Tandai Siap
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
    // Auto-refresh halaman setiap 15 detik
    setInterval(() => location.reload(), 15000);

    // Update status pesanan
    function updateStatus(id, status) {
        fetch(`/kitchen/${id}/status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            },
            body: JSON.stringify({ status_pesanan: status }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                if (status === 'siap' || status === 'selesai') {
                    document.getElementById(`card-${id}`)?.remove();
                } else {
                    location.reload();
                }
            }
        });
    }
</script>
@endpush
