@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Kantin — Menu Pemesanan')

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
    .anim-card:nth-child(4) { animation-delay: 0.20s; }

    @keyframes fadeSlideUpPanel {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .anim-panel { animation: fadeSlideUpPanel 0.55s ease both; }
    .anim-panel:nth-child(1) { animation-delay: 0.25s; }
    .anim-panel:nth-child(2) { animation-delay: 0.35s; }

    .progress-bar-track {
        background: rgba(255,255,255,0.08);
        border-radius: 999px;
        height: 6px;
        overflow: hidden;
    }
    .progress-bar-fill {
        height: 100%;
        border-radius: 999px;
        background: linear-gradient(90deg, #E491C9, #982598);
        transition: width 1s ease;
    }
    .rank-badge {
        width: 28px; height: 28px;
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 900;
        flex-shrink: 0;
    }
    tr.txn-row { transition: background 0.2s; }
    tr.txn-row:hover td { background: #f5f3ff; }

    .hero-banner {
        background: linear-gradient(135deg, #15173D 0%, #2d1b69 50%, #15173D 100%);
        position: relative;
        overflow: hidden;
    }
    .hero-banner::after {
        content: '';
        position: absolute;
        top: -30px; right: -30px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(228,145,201,0.2) 0%, transparent 70%);
    }
</style>
@endpush

@section('content')
<div class="space-y-6">

    {{-- Hero Banner --}}
    <div class="hero-banner rounded-2xl p-6 lg:p-8 text-white shadow-xl">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 relative z-10">
            <div>
                <p class="text-tertiary text-xs font-black uppercase tracking-[0.2em] mb-1">
                    {{ now()->translatedFormat('l, d F Y') }}
                </p>
                <h2 class="text-2xl lg:text-3xl font-black leading-tight">
                    Selamat datang, <span class="text-tertiary">{{ Str::words(auth()->user()->name, 1, '') }}</span>!
                </h2>
                <p class="text-white/50 text-sm font-medium mt-1">
                    @if(auth()->user()->isAdmin())
                        Panel Admin — Pantau kinerja operasional kantin Anda hari ini.
                    @else
                        Panel Kantin — Siap melayani transaksi hari ini.
                    @endif
                </p>
            </div>

        </div>
    </div>

    @if(auth()->user()->isAdmin())

    {{-- Stat Cards (Admin) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        {{-- Pendapatan --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #1e3a5f 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #3b82f6;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(59,130,246,0.15); border: 1px solid rgba(59,130,246,0.2);">
                    <span class="material-symbols-outlined text-blue-400 !text-[22px]">payments</span>
                </div>
                <span class="text-[10px] text-blue-300/60 font-black uppercase tracking-widest">Hari Ini</span>
            </div>
            <p class="text-[11px] text-blue-300/50 uppercase tracking-wider font-bold mb-1">Pendapatan Kotor</p>
            <p class="text-2xl font-black text-white tracking-tight">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</p>
        </div>

        {{-- Transaksi --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #2d1b69 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #a855f7;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(168,85,247,0.15); border: 1px solid rgba(168,85,247,0.2);">
                    <span class="material-symbols-outlined text-purple-400 !text-[22px]">receipt_long</span>
                </div>
                <span class="text-[10px] text-purple-300/60 font-black uppercase tracking-widest">Hari Ini</span>
            </div>
            <p class="text-[11px] text-purple-300/50 uppercase tracking-wider font-bold mb-1">Total Transaksi</p>
            <p class="text-2xl font-black text-white tracking-tight">{{ $transaksiHariIni }} <span class="text-sm font-semibold text-white/30">nota</span></p>
        </div>

        {{-- Pending --}}
        <a href="{{ route('transaksi.index', ['status' => 'pending']) }}"
           class="stat-card anim-card rounded-2xl p-5 shadow-lg block"
           style="background: linear-gradient(135deg, #451a03 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #f59e0b;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(245,158,11,0.15); border: 1px solid rgba(245,158,11,0.2);">
                    <span class="material-symbols-outlined text-amber-400 !text-[22px]">hourglass_top</span>
                </div>
                <span class="text-[10px] text-amber-300/60 font-black uppercase tracking-widest">Pending</span>
            </div>
            <p class="text-[11px] text-amber-300/50 uppercase tracking-wider font-bold mb-1">Belum Lunas</p>
            <p class="text-2xl font-black {{ $transaksiPending > 0 ? 'text-amber-400' : 'text-white' }} tracking-tight">
                {{ $transaksiPending }} <span class="text-sm font-semibold text-white/30">nota</span>
            </p>
        </a>

        {{-- Total Menu --}}
        <div class="stat-card anim-card rounded-2xl p-5 shadow-lg"
             style="background: linear-gradient(135deg, #064e3b 0%, #15173D 100%); border: 1px solid rgba(255,255,255,0.06);">
            <div class="card-glow" style="background: #10b981;"></div>
            <div class="flex justify-between items-start mb-4">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center" style="background: rgba(16,185,129,0.15); border: 1px solid rgba(16,185,129,0.2);">
                    <span class="material-symbols-outlined text-emerald-400 !text-[22px]">restaurant_menu</span>
                </div>
                <span class="text-[10px] text-emerald-300/60 font-black uppercase tracking-widest">Katalog</span>
            </div>
            <p class="text-[11px] text-emerald-300/50 uppercase tracking-wider font-bold mb-1">Menu Aktif</p>
            <p class="text-2xl font-black text-white tracking-tight">
                {{ $totalMenuAktif }} <span class="text-sm font-semibold text-white/30">item</span>
            </p>
        </div>

    </div>
    @endif

    {{-- Mid-tier Analytics --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        {{-- Metode Pembayaran --}}
        <div class="anim-panel bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-black text-gray-900 text-sm tracking-tight">Metode Pembayaran</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">Hari Ini</p>
                </div>
                <span class="material-symbols-outlined text-primary/20">account_balance_wallet</span>
            </div>
            <div class="space-y-4">
                @php
                    $totalMetode = $distribusiBayar->sum('total') ?: 1;
                @endphp
                @foreach(['tunai' => 'payments', 'non_tunai' => 'qr_code_2'] as $metode => $icon)
                    @php
                        $data = $distribusiBayar->where('metode_bayar', $metode)->first();
                        $count = $data ? $data->total : 0;
                        $pct = round(($count / $totalMetode) * 100);
                        $color = $metode === 'tunai' ? 'emerald' : 'blue';
                    @endphp
                    <div class="space-y-2">
                        <div class="flex justify-between items-center text-xs font-bold uppercase">
                            <div class="flex items-center gap-2 text-gray-500">
                                <span class="material-symbols-outlined !text-[16px] text-{{ $color }}-500">{{ $icon }}</span>
                                {{ str_replace('_', ' ', $metode) }}
                            </div>
                            <span class="text-gray-900">{{ $count }} Txn</span>
                        </div>
                        <div class="h-2 bg-gray-50 rounded-full overflow-hidden border border-gray-100">
                            <div class="h-full bg-{{ $color }}-500 rounded-full transition-all duration-1000" style="width: {{ $pct }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Performa Kategori --}}
        <div class="anim-panel bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-black text-gray-900 text-sm tracking-tight">Performa Kategori</h3>
                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-widest mt-0.5">30 Hari Terakhir</p>
                </div>
                <span class="material-symbols-outlined text-primary/20">dashboard_customize</span>
            </div>
            <div class="space-y-3">
                @forelse($performaKategori->take(3) as $kat)
                <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100 group hover:border-primary/20 transition-all">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-primary shadow-sm">
                            <span class="material-symbols-outlined !text-[18px]">category</span>
                        </div>
                        <p class="text-xs font-black text-gray-700">{{ $kat->nama }}</p>
                    </div>
                    <p class="text-[11px] font-black text-primary">Rp {{ number_format($kat->total_pendapatan, 0, ',', '.') }}</p>
                </div>
                @empty
                <p class="text-center text-xs text-gray-400 py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>

        {{-- Kantin Teraktif --}}
        <div class="anim-panel bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xs font-black text-gray-400 uppercase tracking-widest">Kantin Teraktif</h3>
                <span class="material-symbols-outlined text-gray-300 !text-[18px]">engineering</span>
            </div>
            <div class="space-y-4">
                @forelse($kantinTeraktif as $kantin)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] font-black border border-indigo-100">
                        {{ substr($kantin->name, 0, 1) }}
                    </div>
                    <div class="flex-1">
                        <p class="text-xs font-black text-gray-800">{{ $kantin->name }}</p>
                        <p class="text-[10px] text-gray-400 font-bold uppercase">{{ $kantin->total_transaksi }} Transaksi</p>
                    </div>
                </div>
                @empty
                <p class="text-[10px] text-gray-400 text-center py-2 italic">Belum ada aktivitas</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Bottom Panels --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-5">

        {{-- Aktivitas Transaksi (wider) --}}
        <div class="anim-panel lg:col-span-3 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <h3 class="font-black text-gray-900 text-sm tracking-tight">Aktivitas Transaksi</h3>
                    <p class="text-xs text-gray-400 font-medium mt-0.5">10 log transaksi terakhir</p>
                </div>
                <a href="{{ route('transaksi.index') }}"
                   class="text-[11px] font-black text-secondary bg-secondary/5 border border-secondary/10 px-3 py-1.5 rounded-lg hover:bg-secondary/10 transition-colors tracking-wide uppercase">
                    Lihat Semua
                </a>
            </div>
            <div class="overflow-auto flex-1 custom-scrollbar" style="max-height: 300px;">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-3 text-[10px] text-gray-400 font-black uppercase tracking-widest">Waktu</th>
                            <th class="px-6 py-3 text-[10px] text-gray-400 font-black uppercase tracking-widest">Kode</th>
                            <th class="px-6 py-3 text-[10px] text-gray-400 font-black uppercase tracking-widest">Kantin</th>
                            <th class="px-6 py-3 text-[10px] text-gray-400 font-black uppercase tracking-widest text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $t)
                        <tr class="txn-row border-b border-gray-50 last:border-0">
                            <td class="px-6 py-3.5">
                                <span class="inline-flex items-center gap-1.5 text-gray-400 text-xs font-semibold">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-400 animate-pulse inline-block"></span>
                                    {{ $t->created_at->format('H:i') }}
                                </span>
                            </td>
                            <td class="px-6 py-3.5">
                                <code class="text-[11px] text-primary bg-primary/5 px-2 py-0.5 rounded font-bold tracking-tight">{{ $t->kode_transaksi }}</code>
                            </td>
                            <td class="px-6 py-3.5 text-gray-700 font-semibold text-sm">{{ $t->user?->name ?? 'Sistem' }}</td>
                            <td class="px-6 py-3.5 text-right">
                                <span class="text-gray-900 font-black text-sm tracking-tight">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-2">
                                    <span class="material-symbols-outlined text-gray-200 !text-[40px]">receipt_long</span>
                                    <p class="text-sm font-bold text-gray-400">Belum ada transaksi hari ini</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Menu Performa Tinggi --}}
        <div class="anim-panel lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 flex flex-col">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="font-black text-gray-900 text-sm tracking-tight">Menu Performa Tinggi</h3>
                <p class="text-xs text-gray-400 font-medium mt-0.5">30 hari terakhir</p>
            </div>
            <div class="p-6 space-y-5 flex-1">
                @forelse($menuTerlaris as $i => $menu)
                @php
                    $max = $menuTerlaris->first()->total_terjual ?? 1;
                    $pct = $max > 0 ? round(($menu->total_terjual / $max) * 100) : 0;
                    $colors = [
                        0 => ['bg' => 'bg-amber-400', 'text' => 'text-amber-700', 'card' => 'bg-amber-50 border-amber-100'],
                        1 => ['bg' => 'bg-gray-400',  'text' => 'text-gray-600',  'card' => 'bg-gray-50 border-gray-100'],
                        2 => ['bg' => 'bg-orange-400','text' => 'text-orange-700','card' => 'bg-orange-50 border-orange-100'],
                    ];
                    $c = $colors[$i] ?? ['bg' => 'bg-purple-400', 'text' => 'text-purple-700', 'card' => 'bg-purple-50 border-purple-100'];
                @endphp
                <div class="flex flex-col gap-2">
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="rank-badge {{ $c['card'] }} border {{ $c['text'] }}">
                                #{{ $i + 1 }}
                            </div>
                            <p class="text-sm font-bold text-gray-800 truncate">{{ $menu->nama_menu }}</p>
                        </div>
                        <span class="shrink-0 text-xs font-black {{ $c['text'] }}">{{ $menu->total_terjual }}×</span>
                    </div>
                    <div class="progress-bar-track bg-gray-100">
                        <div class="progress-bar-fill" style="width: {{ $pct }}%; background: linear-gradient(90deg, {{ ['#f59e0b','#9ca3af','#f97316'][$i] ?? '#a855f7' }}, {{ ['#d97706','#6b7280','#ea580c'][$i] ?? '#7c3aed' }});"></div>
                    </div>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center h-full py-8 text-center gap-3">
                    <span class="material-symbols-outlined text-gray-200 !text-[48px]">restaurant_menu</span>
                    <p class="text-sm font-bold text-gray-400">Belum ada data penjualan</p>
                    <p class="text-xs text-gray-300">Data akan muncul setelah transaksi dilakukan</p>
                </div>
                @endforelse
            </div>
        </div>

    </div>
    {{-- Sales Trend Chart --}}
    <div class="anim-panel bg-white rounded-2xl shadow-sm border border-gray-100 p-6 lg:p-8 mt-6">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
            <div>
                <h3 class="font-black text-gray-900 text-lg tracking-tight">Tren Penjualan</h3>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Analisis pendapatan dalam 7 hari terakhir</p>
            </div>
            <div class="flex items-center gap-2 px-4 py-2 bg-gray-50 rounded-xl border border-gray-100">
                <span class="w-3 h-3 rounded-full bg-primary shadow-[0_0_8px_rgba(21,23,61,0.4)]"></span>
                <span class="text-[11px] font-black text-gray-600 uppercase tracking-widest">Pendapatan (IDR)</span>
            </div>
        </div>
        <div class="h-[300px] w-full">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('salesTrendChart').getContext('2d');
        
        // Gradient for the chart
        const gradient = ctx.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(192, 38, 211, 0.15)');
        gradient.addColorStop(1, 'rgba(192, 38, 211, 0)');

        const rawData = @json($grafikData);
        
        // Fill in missing dates for the last 7 days
        const labels = [];
        const values = [];
        for (let i = 6; i >= 0; i--) {
            const date = new Date();
            date.setDate(date.getDate() - i);
            const dateString = date.toISOString().split('T')[0];
            
            const label = date.toLocaleDateString('id-ID', { day: 'numeric', month: 'short' });
            labels.push(label);
            
            const match = rawData.find(d => d.tanggal === dateString);
            values.push(match ? parseFloat(match.total) : 0);
        }

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Total Penjualan',
                    data: values,
                    borderColor: '#c026d3',
                    borderWidth: 4,
                    pointBackgroundColor: '#FFFFFF',
                    pointBorderColor: '#c026d3',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#c026d3',
                        titleFont: { size: 12, weight: 'bold' },
                        bodyFont: { size: 13, weight: 'bold' },
                        padding: 12,
                        displayColors: false,
                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                            }
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0, 0, 0, 0.03)', drawBorder: false },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8',
                            callback: function(value) {
                                if (value >= 1000000) return (value / 1000000) + 'jt';
                                if (value >= 1000) return (value / 1000) + 'rb';
                                return value;
                            }
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: {
                            font: { size: 10, weight: 'bold' },
                            color: '#94a3b8'
                        }
                    }
                }
            }
        });
    });
</script>
@endpush
@endsection
