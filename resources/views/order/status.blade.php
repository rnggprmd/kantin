<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Status Pesanan | {{ $transaksi->kode_transaksi }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container-lowest": "#ffffff",
                        "on-surface-variant": "#46464e",
                        "surface": "#f8f9fa",
                        "inverse-surface": "#2e3132",
                        "on-background": "#191c1d",
                        "secondary": "#9d2a9d",
                        "secondary-container": "#fe82f7",
                        "surface-container-high": "#e7e8e9",
                        "surface-container": "#edeeef",
                        "background": "#f8f9fa",
                        "outline-variant": "#c7c5cf",
                        "primary": "#000000",
                        "on-primary": "#ffffff",
                        "outline": "#77767f",
                        "primary-container": "#15173d",
                        "surface-container-low": "#f3f4f5",
                        "on-surface": "#191c1d",
                        "secondary-fixed": "#ffd7f6",
                        "on-primary-fixed": "#15173d",
                    },
                    "borderRadius": {
                        "xxl": "1.5rem"
                    },
                    "spacing": {
                        "xl": "32px",
                        "gutter": "24px",
                        "lg": "24px",
                        "sm": "12px",
                        "md": "16px",
                        "base": "8px",
                        "xs": "4px",
                        "xxl": "48px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "label-md": ["Inter"],
                        "headline-sm": ["Plus Jakarta Sans"],
                        "headline-md": ["Plus Jakarta Sans"],
                        "headline-lg": ["Plus Jakarta Sans"],
                        "headline-xl": ["Plus Jakarta Sans"],
                        "body-sm": ["Inter"]
                    }
                }
            }
        }
    </script>
    <style>
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .pulse-soft {
            box-shadow: 0 0 0 0 rgba(157, 42, 157, 0.4);
            animation: pulse-ring 2s infinite;
        }
        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(157, 42, 157, 0.4); }
            70% { box-shadow: 0 0 0 15px rgba(157, 42, 157, 0); }
            100% { box-shadow: 0 0 0 0 rgba(157, 42, 157, 0); }
        }
        
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>

    @if($transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token)
    <script src="https://app.{{ config('services.midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    @endif
</head>
<body class="bg-surface font-body-md text-on-surface min-h-screen">

<!-- TopAppBar -->
<header class="w-full top-0 sticky bg-surface-container-low shadow-sm z-40">
    <div class="flex justify-between items-center px-lg py-md w-full max-w-7xl mx-auto">
        <div class="flex items-center gap-md">
            <span class="material-symbols-outlined text-primary text-headline-md" data-icon="restaurant">restaurant</span>
            <h1 class="font-headline-md text-headline-md font-bold text-on-surface">Kantin Maria</h1>
        </div>
    </div>
</header>

<main class="max-w-4xl mx-auto px-4 sm:px-gutter py-xl">
    <section class="space-y-gutter">
        
        <!-- Breadcrumb/Header -->
        <div class="flex justify-between items-end">
            <div>
                <span class="text-label-md text-secondary font-bold uppercase tracking-wider">Status Pesanan Aktif</span>
                <h2 class="font-headline-lg text-headline-lg">{{ $transaksi->kode_transaksi }}</h2>
            </div>
            <div class="text-right">
                <p class="text-body-sm text-on-surface-variant">Waktu Pesan</p>
                <p class="font-headline-sm text-secondary">{{ $transaksi->created_at->format('H:i') }}</p>
            </div>
        </div>

        <!-- Glassmorphism Order Status Card -->
        <div class="relative overflow-hidden rounded-xxl p-xl md:p-xxl bg-primary-container text-white shadow-xl min-h-[350px] flex flex-col justify-center">
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-secondary opacity-20 blur-3xl rounded-full"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-64 h-64 bg-secondary-container opacity-10 blur-3xl rounded-full"></div>
            
            <div class="relative z-10 glass-panel rounded-xxl p-lg md:p-xl shadow-2xl flex flex-col md:flex-row items-center gap-xl">
                <!-- Queue Number -->
                <div class="flex-shrink-0">
                    <div class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-secondary pulse-soft flex flex-col items-center justify-center bg-primary-container relative z-20">
                        <span class="text-label-md text-secondary-fixed opacity-80 uppercase">Antrean</span>
                        <span class="font-headline-xl text-white text-5xl md:text-6xl font-extrabold tracking-tighter">{{ str_pad($transaksi->nomor_antrean, 3, '0', STR_PAD_LEFT) }}</span>
                    </div>
                </div>
                
                <!-- Stepper -->
                @php
                    // Merge 'siap' and 'selesai' into a single final step index (2)
                    if (in_array($transaksi->status_pesanan, ['siap', 'selesai'])) {
                        $currentIdx = 2;
                    } elseif ($transaksi->status_pesanan === 'diproses') {
                        $currentIdx = 1;
                    } else {
                        $currentIdx = 0; // menunggu
                    }
                    $progressWidth = ($currentIdx / 2) * 100;
                @endphp
                
                <div class="flex-grow w-full mt-8 md:mt-0 relative z-10">
                    <div class="flex justify-between items-start relative mb-base">
                        <!-- Progress Line Background -->
                        <div class="absolute top-6 left-0 w-full h-1 bg-white/20 -z-10"></div>
                        <!-- Progress Line Active -->
                        <div class="absolute top-6 left-0 h-1 bg-secondary shadow-[0_0_10px_rgba(157,42,157,0.8)] -z-10 transition-all duration-500" style="width: {{ $progressWidth }}%"></div>
                        
                        @foreach([
                            ['check_circle', 'Diterima'],
                            ['cooking', 'Dimasak'],
                            ['inventory_2', 'Selesai']
                        ] as $idx => [$icon, $label])
                        
                            @php
                                $isDone = $currentIdx > $idx;
                                $isActive = $currentIdx === $idx;
                                $isPending = $currentIdx < $idx;
                            @endphp
                            
                            <div class="flex flex-col items-center text-center w-1/3">
                                <div class="w-12 h-12 rounded-full flex items-center justify-center mb-sm relative
                                    {{ $isDone ? 'bg-secondary text-white shadow-lg' : '' }}
                                    {{ $isActive ? 'bg-secondary border-2 border-white text-white shadow-lg' : '' }}
                                    {{ $isPending ? 'bg-white/10 text-white/40 border border-white/20' : '' }}">
                                    <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' {{ $isDone || $isActive ? '1' : '0' }};">{{ $icon }}</span>
                                    
                                    @if($isActive)
                                    <div class="absolute inset-0 rounded-full animate-ping bg-secondary opacity-40"></div>
                                    @endif
                                </div>
                                <span class="text-label-md font-bold {{ $isPending ? 'text-white/40' : 'text-on-primary-fixed' }}">{{ $label }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="mt-xl text-center md:text-left relative z-10">
                <p class="font-headline-sm text-white">Halo, {{ $transaksi->pelanggan_nama }}!</p>
                <p class="text-body-md text-secondary-fixed opacity-80 mt-xs">
                    @if($transaksi->status_pesanan === 'menunggu')
                        Pesananmu sudah masuk dan sedang menunggu konfirmasi dapur.
                    @elseif($transaksi->status_pesanan === 'diproses')
                        Tunggu sebentar ya, makananmu sedang disiapkan koki kami!
                    @elseif($transaksi->status_pesanan === 'siap')
                        Hore! Pesananmu sudah siap diambil di kantin.
                    @else
                        Pesanan selesai. Selamat menikmati!
                    @endif
                </p>
            </div>
        </div>

        <!-- Bento Grid Details -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
            
            <!-- Order Items List -->
            <div class="md:col-span-2 bg-surface-container-lowest p-lg rounded-xl shadow-sm border border-outline-variant">
                <h3 class="font-headline-sm text-headline-sm mb-lg border-b border-surface-container-high pb-md">Detail Item</h3>
                
                <div class="space-y-md">
                    @foreach($transaksi->details as $d)
                    <div class="flex items-center gap-md">
                        <div class="w-12 h-12 rounded-lg bg-surface-container flex items-center justify-center flex-shrink-0 border border-outline-variant/30">
                            <span class="font-bold text-primary">{{ $d->qty }}×</span>
                        </div>
                        <div class="flex-grow">
                            <div class="flex justify-between items-center">
                                <p class="font-body-md font-bold">{{ $d->nama_menu }}</p>
                                <p class="font-body-md font-bold text-secondary">Rp {{ number_format($d->subtotal, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-body-sm text-on-surface-variant">@ Rp {{ number_format($d->harga_satuan, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="flex items-center gap-md pt-md border-t border-surface-container-high">
                        <div class="flex-grow text-right space-y-xs">
                            <div class="flex justify-between pt-sm font-bold text-headline-sm">
                                <span>Total Tagihan</span>
                                <span class="text-secondary">Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pickup Details & Support -->
            <div class="space-y-gutter">
                <div class="bg-primary-container p-lg rounded-xl text-white shadow-md">
                    <h3 class="font-label-md text-secondary-fixed opacity-70 uppercase tracking-widest mb-md">Lokasi Pengambilan</h3>
                    <div class="flex items-start gap-md">
                        <span class="material-symbols-outlined text-secondary-fixed text-3xl">location_on</span>
                        <div>
                            <p class="font-headline-sm">{{ $transaksi->meja?->nama ?? 'Bawa Pulang' }}</p>
                            <p class="text-body-sm opacity-80 mt-1">Harap tunjukkan layar ini kepada staf.</p>
                        </div>
                    </div>
                    
                    {{-- Payment Action --}}
                    @if($transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token && $transaksi->status === 'pending')
                        @if(!request()->has('paid'))
                        <button onclick="bayar()" class="w-full mt-lg bg-secondary text-white py-sm rounded-lg font-bold shadow-lg shadow-secondary/30 hover:brightness-110 transition-all flex items-center justify-center gap-md active:scale-95 animate-pulse">
                            <span class="material-symbols-outlined">qr_code_scanner</span>
                            Bayar Sekarang
                        </button>
                        @else
                        <div class="w-full mt-lg bg-white/10 border border-white/20 text-white/80 py-sm rounded-lg font-bold flex items-center justify-center gap-2 text-sm">
                            <span class="material-symbols-outlined text-sm">hourglass_empty</span>
                            Verifikasi Pembayaran...
                        </div>
                        @endif
                    @elseif($transaksi->metode_bayar === 'non_tunai' && $transaksi->status === 'selesai')
                        <div class="w-full mt-lg bg-green-500/20 border border-green-500/30 text-green-400 py-sm rounded-lg font-bold flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">check_circle</span>
                            Pembayaran Lunas
                        </div>
                    @elseif($transaksi->metode_bayar === 'tunai')
                        <div class="w-full mt-lg bg-white/10 border border-white/20 text-white py-sm rounded-lg font-bold flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined">payments</span>
                            Bayar di Kasir
                        </div>
                    @endif

                    {{-- Tombol Lanjutkan Pesanan --}}
                    @if($transaksi->meja)
                    <a href="{{ route('order.show', $transaksi->meja->kode) }}" class="w-full mt-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white py-sm rounded-lg font-bold flex items-center justify-center gap-2 transition-all">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                        Pesan Menu Lainnya
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>

{{-- Auto-refresh jika masih menunggu/diproses --}}
@if(in_array($transaksi->status_pesanan, ['menunggu', 'diproses', 'siap']))
<script>
    setTimeout(() => location.reload(), 15000); // refresh tiap 15 detik
</script>
@endif

@if($transaksi->metode_bayar === 'non_tunai' && $transaksi->snap_token)
<script>
    function bayar() {
        if(typeof snap === 'undefined') {
            alert('Sistem pembayaran sedang memuat. Coba lagi dalam beberapa detik.');
            return;
        }
        snap.pay('{{ $transaksi->snap_token }}', {
            onSuccess: () => window.location.href = '?paid=1',
            onPending: () => window.location.href = '?paid=1',
            onError:   () => alert('Pembayaran gagal. Silakan coba lagi.'),
            onClose:   () => {},
        });
    }

    // Auto-open payment gateway if status is still pending and we haven't just paid
    @if($transaksi->status === 'pending')
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (!urlParams.has('paid')) {
            setTimeout(() => {
                if(typeof snap !== 'undefined') bayar();
            }, 500);
        }
    });
    @endif
</script>
@endif

</body>
</html>
