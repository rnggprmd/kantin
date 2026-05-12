@extends('layouts.app')
@section('title', 'Transaksi Baru — POS')
@section('page-title', 'Kantin — Menu Pemesanan')

@section('content')
<div x-data="pos()" class="h-[calc(100vh-6rem)] lg:h-[calc(100vh-7rem)] min-h-[500px]">
    <form method="POST" action="{{ route('transaksi.store') }}" @submit="prepareSubmit" class="h-full">
        @csrf
        <input type="hidden" name="metode_bayar" x-model="metodeBayar">
        <input type="hidden" name="pelanggan_nama" x-model="pelangganNama">
        <input type="hidden" name="uang_bayar" :value="uangBayar || ''">
        <input type="hidden" name="catatan" x-model="catatan">

        <div class="flex flex-col md:flex-row gap-6 h-full">

            {{-- LEFT: Menu Catalog --}}
            <div class="flex-1 flex flex-col min-w-0 h-full bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                
                {{-- Search & Categories --}}
                <div class="p-5 space-y-4 shrink-0 border-b border-gray-50 bg-gray-50/30">
                    {{-- Search --}}
                    <div class="relative group">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 !text-[20px] text-gray-400 group-focus-within:text-primary transition-colors">search</span>
                        <input type="text" x-model="search" placeholder="Cari menu berdasarkan nama..."
                               class="w-full bg-white border border-gray-200 text-gray-800 placeholder-gray-400 rounded-2xl pl-11 pr-4 py-3 text-sm font-bold
                                      focus:outline-none focus:border-primary focus:ring-4 focus:ring-primary/5 transition-all">
                    </div>

                    {{-- Category Tabs --}}
                    <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide">
                        <button type="button" @click="activeKategori = ''"
                                class="px-5 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all border shrink-0 uppercase tracking-widest"
                                :class="activeKategori === '' ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20' : 'bg-white text-gray-400 border-gray-100 hover:border-gray-200 hover:text-gray-600'">
                            Semua
                        </button>
                        @foreach($menus->keys() as $kategori)
                        <button type="button" @click="activeKategori = '{{ $kategori }}'"
                                class="px-5 py-2 rounded-xl text-xs font-black whitespace-nowrap transition-all border shrink-0 uppercase tracking-widest"
                                :class="activeKategori === '{{ $kategori }}' ? 'bg-primary text-white border-primary shadow-lg shadow-primary/20' : 'bg-white text-gray-400 border-gray-100 hover:border-gray-200 hover:text-gray-600'">
                            {{ $kategori ?? 'Lainnya' }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Menu Grid --}}
                <div class="flex-1 overflow-y-auto px-5 py-5 custom-scrollbar">
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                        @foreach($menus as $kategoriNama => $items)
                        @foreach($items as $menu)
                        <div x-show="(activeKategori === '' || activeKategori === '{{ $kategoriNama }}') &&
                                     (search === '' || '{{ strtolower($menu->nama) }}'.includes(search.toLowerCase()))"
                             @click="addToCart({{ json_encode(['id' => $menu->id, 'nama' => $menu->nama, 'harga' => $menu->harga]) }})"
                             class="group bg-white border border-gray-100 hover:border-secondary rounded-2xl overflow-hidden cursor-pointer shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 select-none flex flex-col relative">
                            
 

                            <div class="aspect-[4/3] overflow-hidden bg-gray-50 flex-shrink-0 border-b border-gray-50">
                                @if($menu->gambar)
                                <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                <img src="https://loremflickr.com/400/300/food?lock={{ $menu->id }}" alt="{{ $menu->nama }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="p-4 flex flex-col flex-1 bg-white">
                                <p class="text-[13px] font-black text-gray-900 line-clamp-2 leading-snug group-hover:text-secondary transition-colors" title="{{ $menu->nama }}">{{ $menu->nama }}</p>
                                <div class="mt-auto pt-3 flex items-center justify-between">
                                    <p class="text-sm text-primary font-black tracking-tighter">Rp {{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    <div class="w-7 h-7 rounded-lg bg-gray-50 flex items-center justify-center group-hover:bg-secondary group-hover:text-white transition-colors">
                                        <span class="material-symbols-outlined !text-[16px]">add</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- RIGHT: Cart --}}
            <div class="w-full md:w-72 xl:w-[320px] flex flex-col shrink-0 h-full">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 flex flex-col h-full overflow-hidden">

                    {{-- Cart Header --}}
                    <div class="shrink-0">
                        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-50 bg-gray-50/20">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-secondary/10 flex items-center justify-center text-secondary">
                                    <span class="material-symbols-outlined !text-[18px]">shopping_cart</span>
                                </div>
                                <h3 class="text-gray-900 font-black text-sm tracking-tight">Pesanan Baru</h3>
                            </div>
                            <button type="button" @click="clearCart()" x-show="cart.length > 0"
                                    class="text-[10px] font-black text-red-500 hover:bg-red-50 px-2.5 py-1.5 rounded-lg transition-all uppercase tracking-widest">
                                Hapus
                            </button>
                        </div>
                        <div class="px-6 py-3 border-b border-gray-50">
                            <div class="relative group">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 !text-[18px] text-gray-400 group-focus-within:text-secondary transition-colors">person</span>
                                <input type="text" x-model="pelangganNama" placeholder="Nama Pelanggan (Opsional)"
                                       class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-xl pl-10 pr-3 py-2.5 text-sm font-bold
                                              focus:outline-none focus:border-secondary focus:ring-4 focus:ring-secondary/5 transition-all">
                            </div>
                        </div>
                    </div>

                    {{-- Cart Items --}}
                    <div class="flex-1 overflow-y-auto px-6 py-4 custom-scrollbar">
                        <template x-if="cart.length === 0">
                            <div class="flex flex-col items-center justify-center h-full text-gray-300 py-10">
                                <span class="material-symbols-outlined !text-[48px] mb-3">shopping_basket</span>
                                <p class="text-xs font-black uppercase tracking-widest">Keranjang Kosong</p>
                            </div>
                        </template>

                        <div class="space-y-4">
                            <template x-for="(item, index) in cart" :key="item.id">
                                <div class="flex flex-col gap-1.5 pb-3 border-b border-gray-50 last:border-0 last:pb-0">
                                    {{-- Hidden Inputs --}}
                                    <input type="hidden" :name="'items[' + index + '][menu_id]'" :value="item.id">
                                    <input type="hidden" :name="'items[' + index + '][qty]'" :value="item.qty">
                                    
                                    <div class="flex justify-between items-start gap-3">
                                        <p class="text-[13px] font-black text-gray-900 leading-snug line-clamp-2" x-text="item.nama"></p>
                                        <p class="text-[13px] font-black text-primary shrink-0 tabular-nums" x-text="'Rp' + (item.harga * item.qty).toLocaleString('id-ID')"></p>
                                    </div>
                                    
                                    <div class="flex items-center justify-between mt-1">
                                        <p class="text-[11px] text-gray-400 font-bold" x-text="'@ Rp' + item.harga.toLocaleString('id-ID')"></p>
                                        <div class="flex items-center gap-2 bg-gray-50 p-1 rounded-xl border border-gray-100">
                                            <button type="button" @click="decreaseQty(item)"
                                                    class="w-7 h-7 rounded-lg bg-white shadow-sm border border-gray-200 text-gray-600 flex items-center justify-center hover:bg-gray-50 transition-all font-black">−</button>
                                            <span class="w-6 text-center text-xs font-black text-primary tabular-nums" x-text="item.qty"></span>
                                            <button type="button" @click="increaseQty(item)"
                                                    class="w-7 h-7 rounded-lg bg-primary shadow-lg shadow-primary/20 text-white flex items-center justify-center hover:opacity-90 transition-all font-black">+</button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Summary & Payment --}}
                    <div class="shrink-0 bg-white px-4 py-3 space-y-2 border-t border-gray-100 rounded-b-3xl shadow-[0_-10px_25px_rgba(0,0,0,0.03)]">

                        {{-- Total --}}
                        <div class="flex items-center justify-between">
                            <span class="text-gray-400 text-[8px] font-black uppercase tracking-widest">Total Bayar</span>
                            <span class="text-xl font-black text-primary tracking-tighter tabular-nums" x-text="'Rp' + total.toLocaleString('id-ID')"></span>
                        </div>

                        {{-- Payment Method Toggle --}}
                        <div class="bg-gray-100 p-0.5 rounded-lg border border-gray-200 flex">
                            <button type="button" @click="metodeBayar = 'tunai'"
                                    class="flex-1 py-1.5 rounded-md text-[8px] font-black transition-all uppercase tracking-widest flex items-center justify-center gap-1.5"
                                    :class="metodeBayar === 'tunai' ? 'bg-white text-primary shadow-sm border border-gray-100' : 'text-gray-400 hover:text-gray-600'">
                                <span class="material-symbols-outlined !text-[12px]">payments</span> Tunai
                            </button>
                            <button type="button" @click="metodeBayar = 'non_tunai'"
                                    class="flex-1 py-1.5 rounded-md text-[8px] font-black transition-all uppercase tracking-widest flex items-center justify-center gap-1.5"
                                    :class="metodeBayar === 'non_tunai' ? 'bg-white text-primary shadow-sm border border-gray-100' : 'text-gray-400 hover:text-gray-600'">
                                <span class="material-symbols-outlined !text-[12px]">credit_card</span> Non Tunai
                            </button>
                        </div>

                        {{-- Uang Bayar (Tunai Only) --}}
                        <div x-show="metodeBayar === 'tunai'" x-transition x-cloak class="space-y-2">
                            <div class="relative group">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-black text-[9px]">Rp</span>
                                <input type="number" x-model.number="uangBayar" placeholder="Bayar..."
                                       class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-lg pl-7 pr-2 py-1.5 text-[11px]
                                              font-black focus:outline-none focus:border-secondary transition-all tabular-nums" min="0">
                            </div>
                            <div x-show="uangBayar > 0" class="flex justify-between items-center bg-green-50 rounded-lg px-3 py-1.5 border border-green-100/30">
                                <span class="text-green-800 font-black text-[8px] uppercase tracking-widest">Kembali</span>
                                <span class="text-green-700 font-black text-xs tabular-nums" x-text="'Rp ' + Math.max(0, kembalian).toLocaleString('id-ID')"></span>
                            </div>
                        </div>

                        {{-- Non Tunai Note --}}
                        <div x-show="metodeBayar !== 'tunai'" x-transition x-cloak
                             class="text-[8px] text-amber-700 bg-amber-50 border border-amber-200/30 rounded-lg px-2.5 py-1.5 font-black flex items-center gap-1.5 leading-tight uppercase tracking-wide">
                             <span class="material-symbols-outlined !text-[14px] shrink-0">speed</span>
                             Gateway Aktif
                        </div>

                        {{-- Catatan --}}
                        <div class="relative group">
                            <span class="material-symbols-outlined absolute left-2.5 top-1/2 -translate-y-1/2 !text-[14px] text-gray-400 group-focus-within:text-primary transition-colors">notes</span>
                            <input type="text" x-model="catatan" placeholder="Catatan..."
                                   class="w-full bg-white border border-gray-200 text-gray-900 placeholder-gray-400 rounded-lg pl-8 pr-2 py-1.5 text-[10px] font-bold
                                          focus:outline-none focus:border-primary transition-all">
                        </div>

                        {{-- Submit Button --}}
                        <button type="submit" id="btn-bayar"
                                :disabled="cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total)"
                                class="w-full py-2.5 flex items-center justify-center font-black rounded-lg text-[9px] transition-all border shrink-0 uppercase tracking-[0.2em] shadow-lg shadow-primary/5"
                                :class="(cart.length === 0 || (metodeBayar === 'tunai' && uangBayar < total)) 
                                    ? 'bg-gray-50 text-gray-400 border-dashed border-gray-300 cursor-not-allowed' 
                                    : 'bg-primary hover:bg-[#0c0d24] text-white border-primary shadow-primary/10 hover:scale-[1.01] active:scale-95'">
                            <span x-show="cart.length === 0">Kosong</span>
                            <span x-show="cart.length > 0 && metodeBayar === 'tunai' && uangBayar < total" x-cloak>Kurang</span>
                            <span x-show="cart.length > 0 && (metodeBayar !== 'tunai' || uangBayar >= total)" x-cloak x-text="metodeBayar === 'tunai' ? 'Cetak Struk' : 'Proses'"></span>
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
                existing.qty++;
            } else {
                this.cart.push({ ...menu, qty: 1 });
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
            if (this.cart.length === 0) {
                alert('Keranjang masih kosong!');
                e.preventDefault();
                return;
            }
            if (this.metodeBayar === 'tunai' && this.uangBayar < this.total) {
                alert('Uang bayar kurang!');
                e.preventDefault();
                return;
            }
        }
    }
}
</script>
@endpush
