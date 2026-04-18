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
                        background: '#F8F9FA',
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
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
    @stack('styles')
</head>
<body class="bg-background text-gray-800 font-sans antialiased" x-data="{ sidebarOpen: true, mobileOpen: false }">

    <!-- Mobile Overlay -->
    <div x-show="mobileOpen" x-cloak @click="mobileOpen = false" class="fixed inset-0 bg-primary/50 z-30 lg:hidden transition-opacity"></div>

    <!-- Sidebar -->
    <aside class="fixed top-0 left-0 h-full z-40 bg-primary text-white flex flex-col transition-all duration-300 shadow-xl overflow-hidden"
           :class="[
               sidebarOpen ? 'w-72' : 'w-20',
               mobileOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'
           ]">
        
        <!-- Logo Area -->
        <div class="flex items-center justify-center h-16 border-b border-white/10 shrink-0 whitespace-nowrap overflow-hidden">
            <span x-show="sidebarOpen" x-cloak class="font-black text-xl tracking-tight transition-opacity duration-300">Kantin<span class="text-tertiary">Maria</span></span>
            <span x-show="!sidebarOpen" x-cloak class="font-black text-xl text-tertiary transition-opacity duration-300">KM</span>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto py-4 font-medium sidebar-nav px-3 space-y-2.5">
            <a href="{{ route('dashboard') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('dashboard') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Dashboard</span>
            </a>

            <a href="{{ route('transaksi.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('transaksi.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Transaksi</span>
            </a>

            <a href="{{ route('inventaris.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('inventaris.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Inventaris</span>
            </a>

            @if(auth()->user()->isAdmin())
            <div class="pt-4 pb-1">
                <span x-show="sidebarOpen" x-cloak class="px-3 text-[10px] uppercase tracking-wider text-tertiary/70 font-bold block mb-1">Manajemen Admin</span>
                <hr x-show="!sidebarOpen" x-cloak class="border-white/10 my-2 mx-2">
            </div>

            <a href="{{ route('kategori.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('kategori.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Kategori Produk</span>
            </a>

            <a href="{{ route('menu.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('menu.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Katalog Menu</span>
            </a>

            <a href="{{ route('laporan.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('laporan.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Laporan Penjualan</span>
            </a>

            <a href="{{ route('pengguna.index') }}" 
               :class="sidebarOpen ? 'px-3 justify-start' : 'px-0 justify-center'"
               class="flex items-center py-2.5 rounded-md transition-colors whitespace-nowrap {{ request()->routeIs('pengguna.*') ? 'bg-secondary text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                <span x-show="sidebarOpen" x-cloak class="ml-3 text-sm">Otorisasi Akses</span>
            </a>
            @endif
        </nav>

        <!-- User Profile Bottom -->
        <div class="border-t border-white/10 p-3 shrink-0" x-data="{ userOpen: false }">
            <div class="relative">
                <button @click="userOpen = !userOpen" @click.away="userOpen = false" class="w-full flex items-center justify-between p-2 rounded-md hover:bg-white/10 transition-colors focus:outline-none">
                    <div class="flex items-center gap-3 overflow-hidden">
                        <div class="w-8 h-8 rounded bg-white flex items-center justify-center text-primary text-sm font-black shrink-0 shadow-sm border border-transparent">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div x-show="sidebarOpen" x-cloak class="flex flex-col items-start min-w-0 truncate text-left">
                            <span class="text-sm font-bold text-white leading-tight truncate w-full">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] uppercase font-bold text-tertiary tracking-wider mt-0.5">{{ auth()->user()->role }}</span>
                        </div>
                    </div>
                </button>
                
                {{-- Dropdown Menu (Upwards) --}}
                <div x-show="userOpen" x-transition.opacity x-cloak class="absolute bottom-full left-0 min-w-[200px] mb-2 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200 text-gray-800">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50/50 rounded-t-md">
                        <p class="text-sm font-bold text-gray-900">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-secondary uppercase font-bold tracking-wider mt-0.5">{{ auth()->user()->role }}</p>
                    </div>
                    <div class="py-1">
                        <a href="{{ route('profile.show') }}" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 font-bold transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Profil & Keamanan
                        </a>
                    </div>
                    <div class="border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 font-bold transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Keluar Sign Out
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Context -->
    <div :class="sidebarOpen ? 'lg:ml-72' : 'lg:ml-20'" class="transition-all duration-300 min-h-screen flex flex-col pt-16">
        
        <!-- Header -->
        <header class="fixed top-0 right-0 left-0 bg-white border-b border-gray-200 z-20 h-16 flex items-center justify-between px-4 lg:px-6 transition-all duration-300"
                :class="sidebarOpen ? 'lg:left-72' : 'lg:left-20'">
            
            {{-- Left Side Header --}}
            <div class="flex items-center gap-4">
                <button @click="mobileOpen = !mobileOpen" class="text-gray-500 hover:text-primary lg:hidden p-1.5 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block text-gray-500 hover:text-primary p-1.5 rounded-md hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="hidden sm:flex items-center text-sm font-medium text-gray-400 gap-2">
                    <a href="{{ route('dashboard') }}" class="hover:text-primary transition-colors">Workspace</a>
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-gray-900 font-bold tracking-tight">@yield('page-title', 'Dashboard')</span>
                </div>
            </div>

            {{-- Right Side Header --}}
            <div class="flex items-center gap-2 sm:gap-4">
                <div x-data="{ time: '' }" x-init="setInterval(() => { time = new Date().toLocaleTimeString('id-ID', { timeZone: 'Asia/Jakarta', hour: '2-digit', minute: '2-digit' }) + ' WIB' }, 1000)" class="text-[13px] font-bold text-gray-500 hidden md:flex items-center gap-2 pr-2">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-text="time"></span>
                </div>
                
                <div class="w-px h-8 bg-gray-200 hidden sm:block"></div>

                <a href="{{ route('transaksi.create') }}" class="flex items-center gap-2 px-4 py-2 bg-secondary hover:opacity-90 text-white text-sm font-bold rounded-md transition-all shadow-sm shrink-0 border border-[#7A1D7A]">
                    <svg class="w-4 h-4 shrink-0 shadow-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span class="hidden sm:inline">POS Kasir</span>
                </a>
            </div>
        </header>

        <!-- Flash Messages -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition class="m-4 lg:m-6 mb-0 p-4 bg-green-50 border border-green-200 rounded-md flex items-start gap-3 text-green-800 text-sm shadow-sm relative">
            <svg class="w-5 h-5 text-green-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="flex-1 font-bold">{{ session('success') }}</span>
            <button @click="show = false" class="absolute top-4 right-4 text-green-600 hover:text-green-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        @endif
        
        @if($errors->any())
        <div x-data="{ show: true }" x-show="show" x-transition class="m-4 lg:m-6 mb-0 p-4 bg-red-50 border border-red-200 rounded-md flex items-start gap-3 text-red-800 text-sm shadow-sm relative">
            <svg class="w-5 h-5 text-red-600 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            <div class="flex-1 font-bold pr-4">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
            <button @click="show = false" class="absolute top-4 right-4 text-red-600 hover:text-red-800">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
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
