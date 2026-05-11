@extends('layouts.app')
@section('title', 'Transaksi Baru — POS')
@section('page-title', 'Kasir — Menu Pemesanan')

@section('content')
<div x-data="pos()" class="h-[calc(100vh-6rem)] lg:h-[calc(100vh-7rem)] min-h-[500px]">
    <form method="POST" action="{{ route('transaksi.store') }}" @submit="prepareSubmit" class="h-full">
        @csrf
        <input type="hidden" name="metode_bayar" x-model="metodeBayar">
        <input type="hidden" name="pelanggan_nama" x-model="pelangganNama">
        <input type="hidden" name="uang_bayar" :value="uangBayar || ''">
        <input type="hidden" name="catatan" x-model="catatan">
        <input type="hidden" name="metode_bayar" x-model="metodeBayar">
        <input type="hidden" name="pelanggan_nama" x-model="pelangganNama">
        <input type="hidden" name="uang_bayar" :value="uangBayar || ''">
        <input type="hidden" name="catatan" x-model="catatan">

        <div class="flex flex-col md:flex-row gap-4 h-full">

            {{-- LEFT: Menu Catalog --}}
            <div class="flex-1 flex flex-col min-w-0 h-full bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                
                {{-- Search & Categories Card --}}
                <div class="p-3.5 space-y-3 shrink-0 border-b border-gray-100 bg-gray-50/30">
                    {{-- Search --}}
                    <div class="flex flex-col sm:flex-row gap-2">
                        <div class="relative flex-1">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            <input type="text" x-model="search" placeholder="Cari menu berdasarkan nama..."
                                   class="w-full bg-white border border-gray-200 text-gray-800 placeholder-gray-400 rounded-lg pl-9 pr-4 py-2.5 text-sm
                                          focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors">
                        </div>
                    </div>

                    {{-- Category Tabs --}}
                    <div class="flex gap-2 overflow-x-auto pb-0.5 scrollbar-none">
                        <button type="button" @click="activeKategori = ''"
                                class="px-5 py-2 border rounded-md text-xs font-bold whitespace-nowrap transition-colors shadow-sm shrink-0"
                                :class="activeKategori === '' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 hover:text-primary'">
                            Semua Menu
                        </button>
                        @foreach($menus->keys() as $kategori)
                        <button type="button" @click="activeKategori = '{{ $kategori }}'"
                                class="px-5 py-2 border rounded-md text-xs font-bold whitespace-nowrap transition-colors shadow-sm shrink-0"
                                :class="activeKategori === '{{ $kategori }}' ? 'bg-primary text-white border-primary' : 'bg-white text-gray-700 border-gray-300 hover:bg-gray-100 hover:text-primary'">
                            {{ $kategori ?? 'Lainnya' }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Menu Grid --}}
                <div class="flex-1 overflow-y-auto px-3.5 py-4 scrollbar-thin scrollbar-thumb-gray-200 scrollbar-track-transparent">
                    <div class="grid grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                        @foreach($menus as $kategoriNama => $items)
                        @foreach($items as $menu)
                        <div x-show="(activeKategori === '' || activeKategori === '{{ $kategoriNama }}') &&
                                     (search === '' || '{{ strtolower($menu->nama) }}'.includes(search.toLowerCase()))"
                             @click="addToCart({{ json_encode(['id' => $menu->id, 'nama' => $menu->nama, 'harga' => $menu->harga, 'stok' => $menu->stok]) }})"
                             class="group bg-white border border-gray-100 hover:border-secondary rounded-xl overflow-hidden cursor-pointer shadow-sm hover:shadow-md transition-all select-none flex flex-col ring-1 ring-gray-100">
                            <div class="aspect-[4/3] overflow-hidden bg-gray-50 flex-shrink-0 border-b border-gray-50">
                                @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                </div>
                                @endif
                            </div>
                            <div class="p-3 flex flex-col flex-1">
                                <p class="text-[13px] font-bold text-gray-900 line-clamp-1" title="{{ $menu->nama }}">{{ $menu->nama }}</p>
                                <div class="mt-auto pt-1.5 flex items-center justify-between">
                                    <p class="text-sm text-primary font-black tracking-tight">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    <p class="text-[10px] text-gray-400 font-bold uppercase tracking-wider">Stok: {{ $menu->stok }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT: Cart --}}
            <div class="w-full md:w-80 xl:w-96 flex flex-col shrink-0 h-full">
                <div class="bg-white border border-gray-200 rounded-xl shadow-sm flex flex-col h-full overflow-hidden">

                    {{-- Cart Header & Pelanggan --}}
                    <div class="shrink-0 bg-gray-50/50">
                        <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200">
                            <h3 class="text-gray-900 font-bold text-sm">Pesanan Baru</h3>
                            <button type="button" @click="clearCart()" x-show="cart.length > 0"
                                    class="text-[11px] font-bold text-red-600 hover:text-red-800 transition-colors bg-red-50 hover:bg-red-100 px-2 py-1 rounded">Bersihkan</button>
                        </div>
                        <div class="px-4 py-3 border-b border-gray-100">
                            <input type="text" x-model="pelangganNama" placeholder="Nama Pelanggan (Opsional)"
                                   class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md px-3 py-2 text-sm
                                          focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors">
                        </div>
                    </div>

                    {{-- Cart Items --}}
                    <div class="flex-1 overflow-y-auto px-4 py-3">
                        <template x-if="cart.length === 0">
                            <div class="flex flex-col items-center justify-center h-full min-h-[120px] text-gray-400">
                                <svg class="w-10 h-10 mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <p class="text-sm font-semibold text-gray-400">Keranjang masih kosong</p>
                            </div>
                        </template>

                        <div class="space-y-3">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="flex flex-col gap-1.5 pb-3 border-b border-gray-100 last:border-0 last:pb-0">
                                    {{-- Hidden Inputs for Form Submission --}}
                                    <input type="hidden" :name="'items[' + index + '][menu_id]'" :value="item.id">
                                    <input type="hidden" :name="'items[' + index + '][qty]'" :value="item.qty">
                                    <div class="flex justify-between items-start min-w-0">
                                        <p class="text-[13px] font-bold text-gray-900 line-clamp-2 leading-tight" x-text="item.nama"></p>
                                        <p class="text-[13px] font-extrabold text-primary ml-2 shrink-0" x-text="'Rp ' + (item.harga * item.qty).toLocaleString('id-ID')"></p>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <p class="text-[11px] text-gray-500 font-medium" x-text="'Rp ' + item.harga.toLocaleString('id-ID') + ' / porsi'"></p>
                                        <div class="flex items-center gap-1.5 shrink-0 bg-gray-50 p-0.5 rounded border border-gray-200">
                                            <button type="button" @click="decreaseQty(item)"
                                                    class="w-6 h-6 rounded bg-white hover:bg-gray-100 text-gray-700 flex items-center justify-center text-lg leading-none transition-colors border border-gray-200 font-bold">−</button>
                                            <span class="w-5 text-center text-xs font-bold text-primary" x-text="item.qty"></span>
                                            <button type="button" @click="increaseQty(item)"
                                                    class="w-6 h-6 rounded bg-primary hover:opacity-90 text-white flex items-center justify-center text-sm leading-none transition-colors font-bold">+</button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Summary & Payment --}}
                    <div class="shrink-0 border-t border-gray-200 bg-white px-4 pt-4 pb-4 space-y-3.5 z-10 box-border border-b-4 border-b-primary rounded-b-xl">

                        {{-- Total --}}
                        <div class="flex items-center justify-between">
                            <span class="text-gray-500 text-[11px] font-bold uppercase tracking-wider">Total Pembayaran</span>
                            <span class="text-2xl font-black text-primary tracking-tight" x-text="'Rp ' + total.toLocaleString('id-ID')"></span>
                        </div>

                        {{-- Box Metode Bayar --}}
                        <div class="bg-gray-100 p-1 rounded-lg border border-gray-200 flex">
                            <button type="button" @click="metodeBayar = 'tunai'"
                                    class="flex-1 text-[11px] py-1.5 rounded-md font-bold transition-all uppercase tracking-wide"
                                    :class="metodeBayar === 'tunai' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200/50' : 'text-gray-500 hover:text-gray-800'">Tunai</button>
                            <button type="button" @click="metodeBayar = 'non_tunai'"
                                    class="flex-1 text-[11px] py-1.5 rounded-md font-bold transition-all uppercase tracking-wide"
                                    :class="metodeBayar === 'non_tunai' ? 'bg-white text-primary shadow-sm ring-1 ring-gray-200/50' : 'text-gray-500 hover:text-gray-800'">Non Tunai</button>
                        </div>

                        {{-- Uang Bayar (Tunai Only) --}}
                        <div x-show="metodeBayar === 'tunai'" x-cloak class="space-y-2">
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500 font-bold text-sm">Rp</span>
                                <input type="number" x-model.number="uangBayar" placeholder="Input uang terima..."
                                       class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md pl-9 pr-3 py-2 text-sm
                                              font-semibold focus:outline-none focus:border-secondary transition-colors" min="0">
                            </div>
                            <div x-show="uangBayar > 0" class="flex justify-between items-center text-sm py-0.5 px-0.5">
                                <span class="text-gray-500 font-semibold text-xs">Kembalian</span>
                                <span :class="Math.max(0, kembalian) > 0 ? 'text-green-600 bg-green-50 px-1.5 py-0.5 rounded' : 'text-gray-900'" class="font-bold text-sm"
                                      x-text="'Rp ' + Math.max(0, kembalian).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        {{-- Non Tunai Note --}}
                        <div x-show="metodeBayar !== 'tunai'" x-cloak
                             class="text-xs text-amber-700 bg-amber-50 border border-amber-200/60 rounded-md px-2.5 py-2 font-medium flex items-center gap-2">
                             <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                             <span class="leading-tight">Akan diproses via Payment Gateway Terintegrasi.</span>
                        </div>

                        {{-- Catatan --}}
                        <input type="text" x-model="catatan" placeholder="Catatan tambahan..."
                               class="w-full bg-white border border-gray-300 text-gray-900 placeholder-gray-400 rounded-md px-3 py-2 text-sm
                                      focus:outline-none focus:border-secondary transition-colors">

                        {{-- Submit --}}
                        <button type="submit" id="btn-bayar"
                                :disabled="cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total)"
                                class="w-full py-3 flex items-center justify-center font-bold rounded-lg text-sm transition-all border shrink-0 uppercase tracking-wide"
                                :class="(cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total)) ? 'bg-gray-50 text-gray-400 border-dashed border-gray-300 cursor-not-allowed' : 'bg-primary hover:bg-[#0c0d24] text-white border-primary shadow-md'">
                            <span x-show="cart.length === 0">Isi Keranjang</span>
                            <span x-show="cart.length > 0 && metodeBayar === 'tunai' && uangBayar < total" x-cloak>Uang Belum Pas</span>
                            <span x-show="cart.length > 0 && (metodeBayar !== 'tunai' || uangBayar >= total)" x-cloak x-text="metodeBayar === 'tunai' ? 'Cetak Struk' : 'Proses Invoice'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function pos() {
    return {
        cart: [],
        search: '',
        activeKategori: '',
        metodeBayar: 'tunai',
        pelangganNama: '',
        uangBayar: 0,
        catatan: '',

        get total() {
            return this.cart.reduce((sum, item) => sum + item.harga * item.qty, 0);
        },
        get kembalian() {
            return this.uangBayar - this.total;
        },

        addToCart(menu) {
            const existing = this.cart.find(i => i.id === menu.id);
            if (existing) {
                if (existing.qty < menu.stok) existing.qty++;
            } else {
                if (menu.stok > 0) this.cart.push({ ...menu, qty: 1 });
            }
        },
        increaseQty(item) {
            const existing = this.cart.find(i => i.id === item.id);
            if(existing) existing.qty++;
        },
        decreaseQty(item) {
            if (item.qty > 1) { item.qty--; }
            else { this.cart = this.cart.filter(i => i.id !== item.id); }
        },
        clearCart() {
            this.cart = [];
            this.uangBayar = 0;
            this.pelangganNama = '';
            this.catatan = '';
        },
        prepareSubmit(e) {
            // Validasi keranjang kosong
            if (this.cart.length === 0) {
                alert('Keranjang masih kosong!');
                e.preventDefault();
                return;
            }

            // Validasi Qty setiap item
            const hasInvalidQty = this.cart.some(item => !item.qty || item.qty < 1);
            if (hasInvalidQty) {
                alert('Ada item dengan jumlah tidak valid!');
                e.preventDefault();
                return;
            }

            // Validasi Uang Bayar jika Tunai
            if (this.metodeBayar === 'tunai' && this.uangBayar < this.total) {
                alert('Uang bayar kurang dari total tagihan!');
                e.preventDefault();
                return;
            }
        }
    }
}
</script>
@endpush
