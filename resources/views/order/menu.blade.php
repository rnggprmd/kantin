<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport"/>
    <title>Pesan Makanan — {{ $meja->nama }}</title>
    
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;600;700;800;900&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .glass-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
        }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        [x-cloak] { display: none !important; }

        .bottom-sheet-enter { transform: translateY(100%); }
        .bottom-sheet-enter-active { transform: translateY(0); transition: transform 0.4s cubic-bezier(0.2, 0.8, 0.2, 1); }
        .bottom-sheet-leave { transform: translateY(0); }
        .bottom-sheet-leave-active { transform: translateY(100%); transition: transform 0.3s cubic-bezier(0.4, 0, 1, 1); }

        .cart-pop { animation: pop 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
        @keyframes pop {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
    
    <script id="tailwind-config">
        tailwind.config = {
          darkMode: "class",
          theme: {
            extend: {
              "colors": {
                      "tertiary-fixed-dim": "#ffade3",
                      "on-secondary": "#ffffff",
                      "on-primary-fixed-variant": "#41436b",
                      "on-secondary-fixed": "#380039",
                      "on-background": "#191c1d",
                      "error": "#ba1a1a",
                      "surface": "#f8f9fa",
                      "on-primary-fixed": "#15173d",
                      "surface-container-high": "#e7e8e9",
                      "on-primary-container": "#7e80ac",
                      "surface-container": "#edeeef",
                      "surface-container-low": "#f3f4f5",
                      "tertiary-container": "#3a0030",
                      "outline-variant": "#c7c5cf",
                      "primary-fixed-dim": "#c1c3f3",
                      "on-tertiary": "#ffffff",
                      "primary-fixed": "#e1e0ff",
                      "on-tertiary-container": "#b76aa0",
                      "on-secondary-fixed-variant": "#800182",
                      "outline": "#77767f",
                      "on-tertiary-fixed": "#3a0030",
                      "on-primary": "#ffffff",
                      "on-secondary-container": "#7b007d",
                      "on-tertiary-fixed-variant": "#712e5f",
                      "primary-container": "#15173d",
                      "on-surface": "#191c1d",
                      "on-error": "#ffffff",
                      "surface-bright": "#f8f9fa",
                      "error-container": "#ffdad6",
                      "tertiary-fixed": "#ffd8ee",
                      "surface-variant": "#e1e3e4",
                      "secondary-fixed-dim": "#f5d0fe",
                      "secondary-fixed": "#ffd7f6",
                      "surface-tint": "#595b85",
                      "on-error-container": "#93000a",
                      "inverse-on-surface": "#f0f1f2",
                      "tertiary": "#000000",
                      "surface-container-highest": "#e1e3e4",
                      "secondary-container": "#fdf4ff",
                      "primary": "#000000",
                      "inverse-primary": "#c1c3f3",
                      "on-surface-variant": "#46464e",
                      "background": "#ffffff",
                      "surface-container-lowest": "#ffffff",
                      "inverse-surface": "#2e3132",
                      "secondary": "#c026d3",
                      "surface-dim": "#d9dadb"
              },
              "borderRadius": {
                      "DEFAULT": "0.25rem",
                      "lg": "0.5rem",
                      "xl": "0.75rem",
                      "full": "9999px",
                      "xxl": "1.5rem"
              },
              "spacing": {
                      "xs": "4px",
                      "gutter": "24px",
                      "lg": "24px",
                      "base": "8px",
                      "sm": "12px",
                      "xxl": "48px",
                      "container-max": "1280px",
                      "md": "16px",
                      "xl": "32px"
              },
              "fontFamily": {
                      "body-md": ["Inter"],
                      "headline-md": ["Plus Jakarta Sans"],
                      "headline-lg-mobile": ["Plus Jakarta Sans"],
                      "body-sm": ["Inter"],
                      "headline-lg": ["Plus Jakarta Sans"],
                      "label-md": ["Inter"],
                      "body-lg": ["Inter"],
                      "headline-xl": ["Plus Jakarta Sans"],
                      "headline-sm": ["Plus Jakarta Sans"]
              },
              "fontSize": {
                      "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                      "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                      "headline-lg-mobile": ["28px", {"lineHeight": "36px", "fontWeight": "700"}],
                      "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}],
                      "headline-lg": ["32px", {"lineHeight": "40px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "label-md": ["12px", {"lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                      "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                      "headline-xl": ["40px", {"lineHeight": "48px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                      "headline-sm": ["20px", {"lineHeight": "28px", "fontWeight": "600"}]
              }
            },
          },
        }
    </script>
</head>
<body x-data="orderApp()" x-init="init()" class="bg-white text-on-background font-body-md min-h-screen flex flex-col pb-24 selection:bg-secondary/20 selection:text-secondary">

    <!-- TopAppBar -->
    <header class="bg-surface/80 glass-header w-full top-0 sticky shadow-sm z-40 border-b border-outline-variant/20">
        <div class="flex justify-between items-center px-lg py-md w-full max-w-container-max mx-auto">
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 rounded-full bg-primary-container text-white flex items-center justify-center">
                    <span class="material-symbols-outlined text-[20px]" data-icon="restaurant">restaurant</span>
                </div>
                <div>
                    <h1 class="font-headline-sm text-on-surface leading-tight">Menu Kantin</h1>
                    <p class="text-[10px] font-bold text-outline uppercase tracking-wider">{{ $meja->nama }}</p>
                </div>
            </div>
            
            {{-- Search Bar (Tablet/Desktop) --}}
            <div class="hidden md:flex flex-1 max-w-md mx-xl">
                <div class="relative w-full group">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors !text-[20px]" data-icon="search">search</span>
                    <input x-model="search" class="w-full pl-12 pr-md py-sm bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-secondary transition-all text-body-sm font-bold placeholder-outline" placeholder="Cari menu favoritmu..." type="text"/>
                </div>
            </div>

            <div class="flex items-center gap-md">
                <button @click="showCart = true" class="relative p-2 text-secondary hover:bg-secondary/10 rounded-full transition-colors flex items-center justify-center">
                    <span class="material-symbols-outlined" data-icon="shopping_cart">shopping_cart</span>

                </button>
            </div>
        </div>
        
        {{-- Search Bar (Mobile) --}}
        <div class="md:hidden px-lg pb-md">
            <div class="relative w-full group">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline group-focus-within:text-secondary transition-colors text-[20px]" data-icon="search">search</span>
                <input x-model="search" class="w-full pl-12 pr-md py-2.5 bg-surface-container-low border-none rounded-xl focus:ring-2 focus:ring-secondary transition-all text-sm font-bold placeholder-outline" placeholder="Cari menu favoritmu..." type="text"/>
            </div>
        </div>
    </header>

    <!-- Main Content Area -->
    <main class="flex-1 w-full max-w-container-max mx-auto p-lg lg:p-xl space-y-xl scroll-smooth">
        <!-- Horizontal Scrollable Recommendations -->
        <section class="space-y-4" x-show="activeKat === 'semua' && !search"
                 x-data="{ 
                    scrollInterval: null,
                    startAutoScroll() {
                        this.scrollInterval = setInterval(() => {
                            const container = this.$refs.recommendationScroll;
                            if (!container) return;
                            const scrollAmount = container.offsetWidth * 0.8;
                            if (container.scrollLeft + container.offsetWidth >= container.scrollWidth - 50) {
                                container.scrollTo({ left: 0, behavior: 'smooth' });
                            } else {
                                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
                            }
                        }, 4000);
                    },
                    stopAutoScroll() {
                        clearInterval(this.scrollInterval);
                    }
                 }" 
                 x-init="startAutoScroll()" 
                 @mouseenter="stopAutoScroll()" 
                 @mouseleave="startAutoScroll()"
                 @touchstart="stopAutoScroll()">
            <div class="flex justify-between items-end">
                <div>
                    <h3 class="font-headline-sm text-on-surface">Pilihan Menu</h3>
                    <div class="h-1 w-8 bg-secondary rounded-full mt-1"></div>
                </div>
            </div>
            
            <div x-ref="recommendationScroll" class="flex gap-4 overflow-x-auto no-scrollbar pb-2 -mx-lg px-lg lg:-mx-xl lg:px-xl scroll-smooth">
                @foreach($menus->where('is_tersedia', true)->take(5) as $r)
                <div class="flex-none w-64 md:w-80 relative rounded-2xl overflow-hidden shadow-sm border border-outline-variant/30 group">
                    <div class="aspect-[16/9]">
                        <img alt="{{ $r->nama }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110" 
                             src="{{ $r->gambar ? asset('storage/'.$r->gambar) : 'https://loremflickr.com/800/600/food?lock='.$r->id }}"/>
                    </div>
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent flex flex-col justify-end p-4">
                        <h4 class="text-white font-bold text-lg mb-2 line-clamp-1">{{ $r->nama }}</h4>
                        <div class="flex justify-between items-center">
                            <span class="text-secondary text-base font-black tracking-tight">Rp {{ number_format($r->harga, 0, ',', '.') }}</span>
                            <button @click="addItem({{ $r->id }})" class="px-4 py-2 bg-white text-primary-container rounded-xl flex items-center justify-center gap-2 shadow-lg active:scale-95 transition-all text-xs font-black uppercase tracking-wider">
                                <span class="material-symbols-outlined !text-[16px]">add</span>
                                Tambah
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>

        <!-- Sticky Category Navigation -->
        <div class="sticky top-[125px] md:top-[85px] z-30 glass-header -mx-lg px-lg py-md lg:-mx-xl lg:px-xl border-y border-outline-variant/30 flex items-center gap-sm overflow-x-auto no-scrollbar">
            <button @click="activeKat = 'semua'"
                    class="whitespace-nowrap px-lg py-2 rounded-full text-sm font-bold shadow-sm transition-all border"
                    :class="activeKat === 'semua' ? 'bg-primary-container text-white border-primary-container' : 'bg-white text-on-surface-variant border-outline-variant hover:bg-surface-container-high'">
                Semua Menu
            </button>
            @foreach($kategoris as $kat)
            <button @click="activeKat = '{{ $kat->id }}'"
                    class="whitespace-nowrap px-lg py-2 rounded-full text-sm font-bold shadow-sm transition-all border"
                    :class="activeKat === '{{ $kat->id }}' ? 'bg-primary-container text-white border-primary-container' : 'bg-white text-on-surface-variant border-outline-variant hover:bg-surface-container-high'">
                {{ $kat->nama }}
            </button>
            @endforeach
        </div>

        <!-- Menu Grid -->
        <div class="space-y-xl">
            @foreach($kategoris as $kat)
            <section x-show="(activeKat === 'semua' || activeKat === '{{ $kat->id }}') && hasVisibleItems('{{ $kat->id }}')" x-transition.opacity>
                <div class="flex justify-between items-end mb-lg">
                    <div>
                        <h3 class="font-headline-md text-on-surface">{{ $kat->nama }}</h3>
                        <div class="h-1 w-12 bg-secondary rounded-full mt-1"></div>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-4 gap-sm md:gap-lg">
                    @foreach($menus->where('kategori_id', $kat->id) as $menu)
                    <!-- Item Card -->
                    <div x-show="isVisible('{{ addslashes($menu->nama) }}')"
                         class="bg-surface-container-lowest rounded-xl sm:rounded-2xl shadow-sm border border-outline-variant/30 group hover:-translate-y-1 sm:hover:-translate-y-2 hover:shadow-xl transition-all duration-300 flex flex-col relative overflow-hidden cursor-pointer"
                         @click="addItem({{ $menu->id }})">
                        
                        {{-- Qty Badge --}}
                        <div x-show="getQty({{ $menu->id }}) > 0" x-transition.scale.origin.top.right
                             class="absolute top-2 right-2 w-8 h-8 rounded-full bg-secondary text-white flex items-center justify-center font-bold text-sm shadow-lg z-10 border-2 border-white cart-pop">
                            <span x-text="getQty({{ $menu->id }})"></span>
                        </div>

                        <div class="relative aspect-[4/3] sm:h-48 rounded-t-xl sm:rounded-t-2xl overflow-hidden bg-surface-container-low border-b border-outline-variant/20 shrink-0">
                            <img alt="{{ $menu->nama }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" 
                                 src="{{ $menu->gambar ? asset('storage/'.$menu->gambar) : 'https://loremflickr.com/400/300/food?lock='.$menu->id }}"/>
                            <div class="absolute inset-0 bg-black/5 group-hover:bg-transparent transition-colors"></div>
                        </div>
                        
                        <div class="p-3 sm:p-md flex flex-col flex-1">
                            <h4 class="font-headline-sm text-sm sm:text-base text-on-surface mb-1 line-clamp-2 leading-snug group-hover:text-secondary transition-colors">{{ $menu->nama }}</h4>
                            
                            <div class="mt-auto pt-3 flex justify-between items-center">
                                <span class="font-bold text-sm sm:text-base text-secondary">Rp {{ number_format($menu->harga, 0, ',', '.') }}</span>
                                <button type="button" class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-secondary text-white flex items-center justify-center shadow-md active:scale-90 transition-transform group-hover:bg-primary-container">
                                    <span class="material-symbols-outlined !text-[18px] sm:!text-[20px]" data-icon="add">add</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
            @endforeach
            
            {{-- Empty State Search --}}
            <div x-show="search !== '' && totalVisibleItems === 0" class="py-xl text-center" x-cloak>
                <div class="w-20 h-20 bg-surface-container-low rounded-full flex items-center justify-center mx-auto mb-md text-outline">
                    <span class="material-symbols-outlined !text-[40px]">search_off</span>
                </div>
                <h3 class="font-headline-sm text-on-surface">Menu tidak ditemukan</h3>
                <p class="text-body-sm text-outline mt-1">Coba gunakan kata kunci pencarian yang lain.</p>
            </div>
        </div>
    </main>

    <!-- Floating Checkout Bar -->
    <div class="fixed bottom-0 inset-x-0 z-50 p-4 bg-gradient-to-t from-background via-background to-transparent md:bg-none" 
         x-show="totalItems > 0" 
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0" 
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-10" x-cloak>
        <div class="max-w-md mx-auto">
            <button @click="showCart = true" class="w-full bg-primary-container text-white rounded-xxl p-4 shadow-2xl flex items-center justify-between hover:bg-primary transition-colors active:scale-95 border border-primary-container/20">
                <div class="flex items-center gap-sm">
                    <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center relative backdrop-blur-sm border border-white/10">
                        <span class="material-symbols-outlined" data-icon="shopping_basket">shopping_basket</span>
                        <div class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-secondary rounded-full flex items-center justify-center text-[11px] font-bold border-2 border-primary-container cart-pop shadow-md" x-text="totalItems"></div>
                    </div>
                    <div class="text-left">
                        <p class="text-[11px] font-bold text-primary-fixed-dim uppercase tracking-wider mb-0.5">Total Pesanan</p>
                        <p class="font-headline-sm text-white" x-text="formatRp(totalHarga)"></p>
                    </div>
                </div>
                <div class="flex items-center gap-1 font-bold text-sm bg-white text-primary-container px-lg py-2.5 rounded-xl shadow-sm">
                    Bayar
                </div>
            </button>
        </div>
    </div>

    <!-- Cart Bottom Sheet Modal -->
    <div x-show="showCart" class="fixed inset-0 z-[60] flex items-end justify-center sm:items-center sm:p-4" x-cloak>
        <!-- Backdrop -->
        <div x-show="showCart" x-transition.opacity @click="showCart = false" class="fixed inset-0 bg-on-background/40 backdrop-blur-sm"></div>
        
        <!-- Sheet -->
        <div x-show="showCart" 
             x-transition:enter="bottom-sheet-enter-active" x-transition:enter-start="bottom-sheet-enter" x-transition:enter-end="bottom-sheet-leave"
             x-transition:leave="bottom-sheet-leave-active" x-transition:leave-start="bottom-sheet-leave" x-transition:leave-end="bottom-sheet-enter"
             class="bg-surface w-full max-w-lg rounded-t-[32px] sm:rounded-[32px] shadow-2xl relative flex flex-col max-h-[92vh] border border-outline-variant/20">
            
            <!-- Handle for mobile -->
            <div class="w-full flex justify-center pt-4 pb-2 sm:hidden cursor-pointer" @click="showCart = false">
                <div class="w-12 h-1.5 bg-outline-variant rounded-full"></div>
            </div>

            <div class="px-xl py-md border-b border-outline-variant/30 flex items-center justify-between shrink-0 bg-surface">
                <h3 class="font-headline-sm text-on-surface flex items-center gap-xs">
                    Keranjang Belanja
                </h3>
                <button @click="showCart = false" class="w-10 h-10 flex items-center justify-center rounded-full bg-surface-container-low text-outline hover:bg-surface-container-high hover:text-on-surface transition-colors">
                    <span class="material-symbols-outlined" data-icon="close">close</span>
                </button>
            </div>

            <!-- Checkout Form wraps content and footer -->
            <form id="orderForm" action="{{ route('order.store', $meja->kode) }}" method="POST" class="flex flex-col flex-1 min-h-0" @submit.prevent="submitForm">
                @csrf
                
                <div class="flex-1 overflow-y-auto p-lg lg:p-xl space-y-xl no-scrollbar bg-surface-container-low/50">
                    <!-- Cart Items -->
                    <div class="space-y-sm">
                        <template x-for="item in cart" :key="item.id">
                            <div class="flex items-center gap-md bg-surface p-sm rounded-2xl border border-outline-variant/30 shadow-sm">
                                <img :src="item.gambar" class="w-16 h-16 rounded-xl object-cover bg-surface-container shrink-0 border border-outline-variant/20">
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-sm text-on-surface truncate" x-text="item.nama"></h4>
                                    <p class="text-sm font-bold text-secondary mt-1" x-text="formatRp(item.harga * item.qty)"></p>
                                </div>
                                <div class="flex items-center gap-sm bg-surface-container-low rounded-xl p-1 border border-outline-variant/30 shrink-0">
                                    <button type="button" @click="removeItem(item.id)" class="w-8 h-8 rounded-lg bg-surface text-on-surface-variant flex items-center justify-center font-bold shadow-sm active:scale-90 transition-transform">−</button>
                                    <span class="w-6 text-center font-bold text-sm text-on-surface" x-text="item.qty"></span>
                                    <button type="button" @click="addItem(item.id)" class="w-8 h-8 rounded-lg bg-secondary text-white flex items-center justify-center font-bold shadow-md active:scale-90 transition-transform">+</button>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="space-y-md">
                        <div class="bg-surface p-lg rounded-2xl border border-outline-variant/30 shadow-sm">
                            <label class="block text-label-md text-on-surface-variant mb-xs">Nama Pemesan</label>
                            <div class="relative">
                                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline !text-[20px]" data-icon="person">person</span>
                                <input type="text" name="nama_pemesan" x-model="namaPemesan" placeholder="Siapa namamu?"
                                       class="w-full bg-surface-container-low border-none text-on-surface rounded-xl pl-12 pr-md py-sm text-body-sm font-bold focus:ring-2 focus:ring-secondary transition-all placeholder-outline">
                            </div>
                        </div>

                        <div class="bg-surface p-lg rounded-2xl border border-outline-variant/30 shadow-sm">
                            <label class="block text-label-md text-on-surface-variant mb-md">Metode Pembayaran</label>
                            <div class="grid grid-cols-1 gap-md">
                                <label class="relative cursor-pointer group">
                                    <input type="radio" name="metode_bayar" value="non_tunai" x-model="metodeBayar" class="peer sr-only">
                                    <div class="p-md rounded-xl border-2 border-outline-variant/50 bg-surface transition-all peer-checked:border-secondary peer-checked:bg-secondary/10 text-center flex flex-col items-center group-hover:border-outline">
                                        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center mb-sm peer-checked:bg-secondary/20 transition-colors">
                                            <span class="material-symbols-outlined text-[24px] text-outline peer-checked:text-secondary transition-colors" data-icon="qr_code_scanner">qr_code_scanner</span>
                                        </div>
                                        <p class="font-bold text-sm text-on-surface-variant peer-checked:text-secondary transition-colors">QRIS / Online</p>
                                        <p class="text-[10px] font-medium text-outline mt-1">E-Wallet / Transfer</p>
                                    </div>
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-outline-variant peer-checked:border-secondary peer-checked:border-[6px] transition-all bg-surface"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-xl bg-surface border-t border-outline-variant/30 shrink-0 sm:rounded-b-[32px]">
                    <div class="flex items-center justify-between mb-lg">
                        <span class="text-sm font-bold text-on-surface-variant">Total Pembayaran</span>
                        <span class="font-headline-md text-primary-container" x-text="formatRp(totalHarga)"></span>
                    </div>
                    <button type="submit" :disabled="cart.length === 0"
                            class="w-full py-4 bg-primary-container hover:bg-primary text-white text-sm font-bold rounded-xl transition-all shadow-lg active:scale-95 flex items-center justify-center gap-xs disabled:opacity-50 disabled:cursor-not-allowed border border-primary-container/20">
                        Selesaikan Pesanan <span class="material-symbols-outlined text-[18px]" data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
        </div>
    </div>

    <script>
        const menuData = {!! json_encode($menus->map(function($m) {
            return [
                'id'          => $m->id,
                'nama'        => $m->nama,
                'harga'       => $m->harga,
                'kategori_id' => $m->kategori_id,
                'gambar'      => $m->gambar ? asset('storage/'.$m->gambar) : 'https://loremflickr.com/400/300/food?lock='.$m->id,
            ];
        })) !!};

        function orderApp() {
            return {
                activeKat: 'semua',
                search: '',
                showCart: false,
                cart: [],
                metodeBayar: 'non_tunai',
                namaPemesan: '',
                menuData,

                init() {
                    this.$watch('cart', () => {
                        if(this.cart.length === 0) this.showCart = false;
                    });
                },

                findMenu(id) { return this.menuData.find(m => m.id === id); },
                getQty(id) { return this.cart.find(i => i.id === id)?.qty ?? 0; },

                isVisible(nama) {
                    if (this.search === '') return true;
                    return nama.toLowerCase().includes(this.search.toLowerCase());
                },

                hasVisibleItems(kategoriId) {
                    return this.menuData.some(m => 
                        (kategoriId === 'semua' || m.kategori_id == kategoriId) && 
                        this.isVisible(m.nama)
                    );
                },

                get totalVisibleItems() {
                    return this.menuData.filter(m => 
                        (this.activeKat === 'semua' || m.kategori_id == this.activeKat) && 
                        this.isVisible(m.nama)
                    ).length;
                },

                addItem(id) {
                    const menu = this.findMenu(id);
                    if (!menu) return;
                    const existing = this.cart.find(i => i.id === id);
                    if (existing) { existing.qty++; }
                    else { this.cart.push({ ...menu, qty: 1 }); }
                },

                removeItem(id) {
                    const existing = this.cart.find(i => i.id === id);
                    if (!existing) return;
                    if (existing.qty > 1) { existing.qty--; }
                    else { this.cart = this.cart.filter(i => i.id !== id); }
                },

                get totalItems() { return this.cart.reduce((s, i) => s + i.qty, 0); },
                get totalHarga() { return this.cart.reduce((s, i) => s + i.harga * i.qty, 0); },
                formatRp(val) { return 'Rp ' + val.toLocaleString('id-ID'); },

                async submitForm(e) {
                    if (this.cart.length === 0) return alert('Keranjang belanja Anda masih kosong!');
                    if (this.namaPemesan.trim() === '') {
                        alert('Silakan isi Nama Pemesan terlebih dahulu.');
                        setTimeout(() => document.querySelector('input[name="nama_pemesan"]').focus(), 100);
                        return;
                    }

                    const btn = e.target.querySelector('button[type="submit"]');
                    const originalText = btn.innerHTML;
                    btn.innerHTML = 'Memproses...';
                    btn.disabled = true;

                    try {
                        const items = this.cart.map(item => ({ menu_id: item.id, qty: item.qty }));
                        
                        const response = await fetch(e.target.action, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                nama_pemesan: this.namaPemesan,
                                metode_bayar: this.metodeBayar,
                                items: items
                            })
                        });

                        const data = await response.json();
                        
                        if (data.success) {
                            if (data.snap_token) {
                                // Tampilkan gateway pembayaran langsung di halaman menu!
                                snap.pay(data.snap_token, {
                                    onSuccess: function() { window.location.href = data.redirect_url + '?paid=1'; },
                                    onPending: function() { window.location.href = data.redirect_url + '?paid=1'; },
                                    onError: function() { window.location.href = data.redirect_url; },
                                    onClose: function() { window.location.href = data.redirect_url; }
                                });
                            } else {
                                window.location.href = data.redirect_url;
                            }
                        } else {
                            alert('Gagal: ' + (data.message || 'Terjadi kesalahan'));
                            btn.innerHTML = originalText;
                            btn.disabled = false;
                        }
                    } catch (error) {
                        alert('Terjadi kesalahan koneksi.');
                        btn.innerHTML = originalText;
                        btn.disabled = false;
                    }
                }
            };
        }
    </script>
</body>
</html>
