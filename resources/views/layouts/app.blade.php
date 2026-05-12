<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Kantin Maria</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#15173D',
                        secondary: '#982598',
                        tertiary: '#E491C9',
                        background: '#F0F2F8',
                    },
                    fontFamily: {
                        sans: ['Inter', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] { display: none !important; }

        /* Custom Scrollbar - Force Visibility */
        .custom-scrollbar::-webkit-scrollbar { 
            width: 6px !important; 
            display: block !important;
        }
        .custom-scrollbar::-webkit-scrollbar-track { 
            background: rgba(0, 0, 0, 0.05) !important; 
            border-radius: 10px !important;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb { 
            background: rgba(228, 145, 201, 0.3) !important; 
            border-radius: 10px !important; 
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { 
            background: rgba(228, 145, 201, 0.5) !important; 
        }

        /* Advanced Animations */
        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(-20px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .nav-item-animate {
            animation: slideInRight 0.5s ease out forwards;
            /* Remove initial opacity: 0 to ensure visibility if animation fails */
        }

        /* Sidebar Transition */
        .sidebar-transition {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Premium Hover & Active States */
        .sidebar-item {
            position: relative;
            transition: all 0.3s ease;
        }
        
        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.05) !important;
            transform: translateX(4px);
        }

        .sidebar-item:hover .material-symbols-outlined {
            color: #E491C9 !important;
            transform: scale(1.1);
        }

        .glass-active {
            background: rgba(228, 145, 201, 0.1) !important;
            border-left: 4px solid #E491C9 !important;
        }

        /* Tooltip */
        .sidebar-tooltip {
            position: absolute;
            left: 100%;
            margin-left: 10px;
            padding: 6px 10px;
            background: #15173D;
            color: white;
            border-radius: 6px;
            font-size: 11px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: 0.2s;
            border: 1px solid rgba(255,255,255,0.1);
            z-index: 50;
        }

        .sidebar-item:hover .sidebar-tooltip {
            opacity: 1;
            visibility: visible;
        }
    </style>
    @stack('styles')
</head>
<body class="text-gray-800 font-sans antialiased" style="background: linear-gradient(135deg, #eef0f8 0%, #f4f0f8 50%, #eef0f8 100%); min-height: 100vh;" x-data="{ sidebarOpen: true, mobileOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" x-cloak @click="mobileOpen = false" class="fixed inset-0 bg-primary/50 z-30 lg:hidden transition-opacity"></div>
    
    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-full z-40 bg-[#15173D] text-white/70 flex flex-col sidebar-transition border-r border-white/10 shadow-2xl"
           style="transition-timing-function: cubic-bezier(0.68, -0.55, 0.27, 1.55);"
           :class="[
               sidebarOpen ? 'w-[280px]' : 'w-20',
               mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
           ]">
        
        <!-- Logo Area -->
        <div class="flex items-center h-20 px-6 border-b border-white/5 shrink-0 overflow-hidden">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center border border-white/10 sidebar-transition">
                    <span class="material-symbols-outlined text-white text-2xl">restaurant</span>
                </div>
                <div x-show="sidebarOpen" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-x-4" x-transition:enter-end="opacity-100 translate-x-0" class="flex flex-col whitespace-nowrap">
                    <span class="font-black text-white text-lg leading-tight">Kantin<span class="text-tertiary">Maria</span></span>
                    <span class="text-[9px] uppercase tracking-[0.2em] font-bold text-white/40 mt-0.5">Management System</span>
                </div>
            </div>
        </div>

        <!-- Navigation Container -->
        <div class="flex-1 overflow-y-auto py-6 px-3 space-y-7 custom-scrollbar">
            
            <!-- Group: Main -->
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black uppercase tracking-[0.15em] text-white/30 mb-3 nav-item-animate" style="animation-delay: 0.1s;">Utama</p>
                <div class="space-y-1">
                    <a href="{{ route('dashboard') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('dashboard') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.2s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('dashboard') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">dashboard</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Dashboard</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Dashboard</span>
                        @if(request()->routeIs('dashboard'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Group: POS -->
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black uppercase tracking-[0.15em] text-white/30 mb-3 nav-item-animate" style="animation-delay: 0.25s;">POS & Transaksi</p>
                <div class="space-y-1">
                    @if(auth()->user()->isAdmin() || auth()->user()->isKantin())
                    <a href="{{ route('transaksi.create') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('transaksi.create') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.3s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('transaksi.create') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">shopping_cart</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Buat Pesanan</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Buat Pesanan</span>
                        @if(request()->routeIs('transaksi.create'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                    @endif

                    <a href="{{ route('transaksi.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('transaksi.index', 'transaksi.show') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.35s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('transaksi.index', 'transaksi.show') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">receipt_long</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Riwayat Transaksi</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Riwayat Transaksi</span>
                        @if(request()->routeIs('transaksi.index', 'transaksi.show'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>

                    <a href="{{ route('kitchen.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('kitchen.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.40s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('kitchen.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">soup_kitchen</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Monitor Dapur</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Monitor Dapur</span>
                        @if(request()->routeIs('kitchen.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Group: Management -->
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black uppercase tracking-[0.15em] text-white/30 mb-3 nav-item-animate" style="animation-delay: 0.4s;">Manajemen</p>
                <div class="space-y-1">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('kategori.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('kategori.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.5s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('kategori.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">category</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Kategori Menu</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Kategori Menu</span>
                        @if(request()->routeIs('kategori.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                    @endif

                    <a href="{{ route('menu.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('menu.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.6s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('menu.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">restaurant_menu</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Katalog Menu</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Katalog Menu</span>
                        @if(request()->routeIs('menu.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('meja.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('meja.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.65s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('meja.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">qr_code_2</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Lokasi & Meja</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Lokasi & Meja</span>
                        @if(request()->routeIs('meja.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                    @endif


                </div>
            </div>

            @if(auth()->user()->isAdmin())
            <!-- Group: Reports -->
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black uppercase tracking-[0.15em] text-white/30 mb-3 nav-item-animate" style="animation-delay: 0.75s;">Laporan</p>
                <div class="space-y-1">
                    <a href="{{ route('laporan.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('laporan.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.8s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('laporan.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">analytics</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Laporan Sales</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Laporan Sales</span>
                        @if(request()->routeIs('laporan.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                </div>
            </div>
            @endif

            @if(auth()->user()->isAdmin())
            <div>
                <p x-show="sidebarOpen" class="px-4 text-[10px] font-black uppercase tracking-[0.15em] text-white/30 mb-3 nav-item-animate" style="animation-delay: 0.8s;">Pengaturan</p>
                <div class="space-y-1">
                    <a href="{{ route('pengguna.index') }}" 
                       class="sidebar-item group flex items-center h-12 rounded-xl relative nav-item-animate {{ request()->routeIs('pengguna.*') ? 'text-white glass-active shadow-sm' : 'hover:bg-white/5 hover:text-white' }}"
                       style="animation-delay: 0.9s;"
                       :class="sidebarOpen ? 'px-4' : 'px-0 justify-center'">
                        <span class="material-symbols-outlined !text-[22px] sidebar-transition {{ request()->routeIs('pengguna.*') ? 'text-tertiary' : 'text-white/40 group-hover:text-white' }}">admin_panel_settings</span>
                        <span x-show="sidebarOpen" class="ml-4 text-sm font-bold tracking-tight">Akses Pengguna</span>
                        <span x-show="!sidebarOpen" class="sidebar-tooltip">Akses Pengguna</span>
                        @if(request()->routeIs('pengguna.*'))
                        <div class="absolute right-3 w-1.5 h-1.5 rounded-full bg-tertiary shadow-[0_0_8px_rgba(228,145,201,0.6)]"></div>
                        @endif
                    </a>
                </div>
            </div>
            @endif
        </div>

        <!-- User Profile Bottom -->
        <div class="p-4 shrink-0 border-t border-white/10 bg-black/10">
            <div x-data="{ userOpen: false }" class="relative">
                <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="w-full group p-2.5 rounded-xl hover:bg-white/5 transition-all duration-200 focus:outline-none">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-10 h-10 rounded-lg bg-tertiary/10 flex items-center justify-center text-tertiary text-sm font-black shrink-0 border border-tertiary/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div x-show="sidebarOpen" x-transition.opacity class="flex flex-col items-start min-w-0 truncate text-left">
                            <span class="text-xs font-bold text-white tracking-tight truncate w-full">{{ auth()->user()->name }}</span>
                            <span class="text-[9px] uppercase font-black text-tertiary tracking-widest mt-0.5">{{ auth()->user()->role }}</span>
                        </div>
                        <span x-show="sidebarOpen" class="material-symbols-outlined text-white/20 text-sm ml-auto group-hover:text-white transition-colors">expand_less</span>
                    </div>
                </button>
                
                {{-- Dropdown Menu (Upwards) --}}
                <div x-show="userOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                     x-cloak class="absolute bottom-full left-0 w-full mb-3 bg-[#1e204a] rounded-xl shadow-2xl py-2 z-50 border border-white/10 text-white/80">
                    
                    <div class="px-4 py-2 border-b border-white/5 mb-1">
                        <p class="text-xs font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[9px] text-tertiary uppercase font-black tracking-widest mt-1">{{ auth()->user()->role }}</p>
                    </div>

                    <a href="{{ route('profile.show') }}" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold hover:bg-white/5 hover:text-white transition-colors">
                        <span class="material-symbols-outlined !text-[18px]">manage_accounts</span>
                        Profil & Keamanan
                    </a>

                    <div class="mt-1 pt-1 border-t border-white/5">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-xs text-red-400 hover:bg-red-400/10 font-bold transition-colors flex items-center gap-3">
                                <span class="material-symbols-outlined !text-[18px]">logout</span>
                                Keluar Sistem
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Context -->
    <div :class="sidebarOpen ? 'lg:ml-[280px]' : 'lg:ml-20'" class="transition-all duration-300 min-h-screen flex flex-col pt-16">
        
        <!-- Header -->
        <header class="fixed top-0 right-0 left-0 z-20 h-16 flex items-center justify-between px-4 lg:px-6 transition-all duration-300"
                style="background: rgba(255,255,255,0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(21,23,61,0.08); box-shadow: 0 1px 20px rgba(21,23,61,0.06);"
                :class="sidebarOpen ? 'lg:left-[280px]' : 'lg:left-20'">
            
            {{-- Left Side Header --}}
            <div class="flex items-center gap-3">
                <button @click="mobileOpen = !mobileOpen" class="text-gray-400 hover:text-primary lg:hidden p-2 rounded-xl hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined !text-[22px]">menu</span>
                </button>
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:flex text-gray-400 hover:text-primary p-2 rounded-xl hover:bg-primary/5 transition-all">
                    <span class="material-symbols-outlined !text-[22px]">menu</span>
                </button>
                <div class="hidden sm:flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="text-xs font-bold text-gray-400 hover:text-primary transition-colors">Dashboard</a>
                    <span class="material-symbols-outlined !text-[14px] text-gray-300">chevron_right</span>
                    <span class="text-xs font-black text-primary tracking-tight">@yield('page-title', 'Dashboard')</span>
                </div>
            </div>

            {{-- Right Side Header --}}
            <div class="flex items-center gap-2 sm:gap-3">
                {{-- Live Clock --}}
                <div x-data="{ time: '' }" x-init="setInterval(() => { time = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit' }) + ' WIB' }, 1000)"
                     class="flex items-center gap-1.5 sm:gap-2">
                    <span class="material-symbols-outlined !text-[16px] text-primary/40">schedule</span>
                    <span x-text="time" class="text-[11px] sm:text-[12px] font-black text-primary tracking-wide whitespace-nowrap"></span>
                </div>


            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="mx-4 lg:mx-6 mt-4 mb-0 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-start gap-3 text-green-800 text-sm shadow-sm relative">
            <div class="w-8 h-8 rounded-xl bg-green-100 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined !text-[18px] text-green-600">check_circle</span>
            </div>
            <div class="flex-1">
                <p class="font-black text-green-800">Berhasil!</p>
                <p class="text-xs text-green-600 font-medium mt-0.5">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="text-green-400 hover:text-green-600 transition-colors">
                <span class="material-symbols-outlined !text-[18px]">close</span>
            </button>
        </div>
        @endif
        
        @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 7000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             class="mx-4 lg:mx-6 mt-4 mb-0 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 text-red-800 text-sm shadow-sm relative">
            <div class="w-8 h-8 rounded-xl bg-red-100 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined !text-[18px] text-red-600">error</span>
            </div>
            <div class="flex-1 pr-4">
                <p class="font-black text-red-800 mb-1">Ada Kesalahan</p>
                <ul class="text-xs text-red-600 font-medium list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors">
                <span class="material-symbols-outlined !text-[18px]">close</span>
            </button>
        </div>
        @endif

        <!-- Main Workspace -->
        <main class="flex-1 p-4 lg:p-6 w-full max-w-full overflow-x-hidden">
            @yield('content')
        </main>
    </div>

    @stack('scripts')

    {{-- Global Confirmation Modal (Premium SaaS Style) --}}
    <div x-data="{ 
            open: false, 
            title: '', 
            message: '', 
            action: '', 
            method: 'POST',
            confirmText: 'Ya, Hapus',
            confirmColor: 'bg-red-600',
            confirm(e) {
                this.title = e.detail.title || 'Konfirmasi Tindakan';
                this.message = e.detail.message || 'Apakah Anda yakin ingin melakukan tindakan ini?';
                this.action = e.detail.action || '';
                this.method = e.detail.method || 'POST';
                this.confirmText = e.detail.confirmText || 'Ya, Lanjutkan';
                this.confirmColor = e.detail.confirmColor || 'bg-red-600';
                this.open = true;
            }
         }" 
         @confirm.window="confirm($event)"
         x-show="open" 
         x-cloak 
         class="fixed inset-0 z-[100] overflow-y-auto" 
         aria-labelledby="modal-title" role="dialog" aria-modal="true">
        
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            {{-- Backdrop --}}
            <div x-show="open" x-transition.opacity @click="open = false" 
                 class="fixed inset-0 bg-primary/40 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            {{-- Modal Content --}}
            <div x-show="open" 
                 x-transition:enter="ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                
                <div class="bg-white px-6 pt-6 pb-4 sm:p-8 sm:pb-6">
                    <div class="sm:flex sm:items-start grow">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-50 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-black text-gray-900" id="modal-title" x-text="title"></h3>
                            <div class="mt-2">
                                <p class="text-sm font-medium text-gray-500 leading-relaxed" x-text="message"></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-50/50 px-6 py-4 sm:px-8 sm:flex sm:flex-row-reverse gap-3 rounded-b-xl border-t border-gray-100">
                    <form :action="action" method="POST">
                        @csrf
                        <template x-if="method !== 'POST'">
                            <input type="hidden" name="_method" :value="method">
                        </template>
                        <button type="submit" 
                                class="w-full inline-flex justify-center rounded-lg border border-transparent px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 transition-all transition-colors"
                                :class="confirmColor"
                                x-text="confirmText"></button>
                    </form>
                    <button type="button" @click="open = false"
                            class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-5 py-2.5 bg-white text-sm font-bold text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary sm:mt-0 transition-all">
                        Batalkan
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
