@extends('layouts.app')

@section('content')
    <div x-data="{
            checkoutOpen: false,
            bayar: 0,
            total: {{ $cartTotal }},
            processing: false,
            cartCount: {{ $cartCount }},
            get isEnough() { return Number(this.bayar) >= Number(this.total); },
            get change() { return Number(this.bayar) - Number(this.total); },
            format(value) { return new Intl.NumberFormat('id-ID').format(value); },
            updateCartFromResponse(result) {
                if (result.cart_html) {
                    document.querySelector('#cart-sidebar').innerHTML = result.cart_html;
                }
                this.cartCount = Number(result.cart_count || 0);
                this.total = Number(result.cart_total || 0);
            },
            async addToCart(productId, price) {
                try {
                    this.processing = true;
                    const response = await fetch('{{ route('transaksi.addCart') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId, qty: 1 })
                    });
                    
                    const result = await response.json();
                    if (!response.ok) {
                        throw new Error(result.error || 'Gagal menambahkan produk');
                    }

                    this.updateCartFromResponse(result);
                    this.showToast('Produk berhasil ditambahkan', 'success');
                } catch (error) {
                    this.showToast(error.message || 'Gagal menambahkan produk', 'error');
                } finally {
                    this.processing = false;
                }
            },
            async updateCartItem(productId, qty) {
                try {
                    this.processing = true;
                    const response = await fetch('{{ route('transaksi.updateCart') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId, qty: qty })
                    });
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.error || 'Gagal update keranjang');
                    
                    this.updateCartFromResponse(result);
                    this.showToast('Keranjang diperbarui', 'success');
                } catch (error) {
                    this.showToast(error.message, 'error');
                } finally {
                    this.processing = false;
                }
            },
            async removeCartItem(productId) {
                try {
                    this.processing = true;
                    const response = await fetch('{{ route('transaksi.removeCart') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ product_id: productId })
                    });
                    const result = await response.json();
                    if (!response.ok) throw new Error(result.error || 'Gagal menghapus produk');
                    
                    this.updateCartFromResponse(result);
                    this.showToast('Item dihapus', 'success');
                } catch (error) {
                    this.showToast(error.message, 'error');
                } finally {
                    this.processing = false;
                }
            },
            showToast(message, type = 'success') {
                this.toast = { visible: true, message, type };
                clearTimeout(this.toastTimeout);
                this.toastTimeout = setTimeout(() => {
                    this.toast.visible = false;
                }, 2500);
            },
            toast: { visible: false, message: '', type: 'success' },
            toastTimeout: null
        }" class="min-h-screen bg-slate-100">
        
        <div class="w-full overflow-x-hidden box-border">
            <div class="w-full px-6 py-6 pb-24 lg:pb-6">
                <!-- Header Section -->
                <div class="sticky top-0 z-30 bg-white rounded-2xl border border-slate-100 shadow-sm p-4 md:p-6 mb-6 w-full">
                <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                    <div class="w-full min-w-0">
                        <h1 class="text-xl md:text-2xl font-bold text-slate-900 truncate">Transaksi POS</h1>
                        <p class="mt-1 text-xs md:text-sm text-slate-500 truncate">Kelola transaksi dengan cepat dan mudah</p>
                    </div>
                    <div class="flex flex-wrap gap-2 sm:gap-3 items-center w-full md:w-auto">
                        <div class="bg-slate-100 px-3 md:px-4 py-2 rounded-xl text-xs md:text-sm text-slate-600 flex-1 sm:flex-none text-center whitespace-nowrap">
                            {{ \Carbon\Carbon::now()->locale('id_ID')->translatedFormat('d F Y') }}
                        </div>
                        <div class="bg-emerald-100 text-emerald-700 px-3 md:px-4 py-2 rounded-xl text-xs md:text-sm font-semibold flex-1 sm:flex-none text-center whitespace-nowrap">
                            {{ ucfirst(auth()->user()->role ?? 'Kasir') }}
                        </div>
                    </div>
                </div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-center shadow-sm border border-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-600">Produk</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-600">{{ $products->count() }}</p>
                    </div>
                    <div class="rounded-2xl bg-slate-50 px-4 py-3 text-center shadow-sm border border-slate-200">
                        <p class="text-xs font-semibold uppercase tracking-widest text-slate-600">Keranjang</p>
                        <p class="mt-2 text-2xl font-bold text-emerald-600" x-text="cartCount">{{ $cartCount }}</p>
                    </div>
                </div>
            </div>

            <!-- Main Grid: 70% Products / 30% Cart -->
            <div class="grid gap-6 lg:grid-cols-[1fr_360px]">
                <!-- Products Section -->
                <section class="space-y-6">
                    <!-- Search Bar -->
                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
                        <form action="{{ route('transaksi.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                            <div class="relative flex-1">
                                <label for="search" class="sr-only">Cari produk</label>
                                <div class="absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input id="search" name="search" type="search" value="{{ $search }}" placeholder="Cari produk..." class="w-full h-12 rounded-xl border border-slate-200 bg-white pl-12 pr-4 text-sm text-slate-900 placeholder:text-slate-400 transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" />
                            </div>
                            <button type="submit" class="h-12 w-full sm:w-auto rounded-xl bg-emerald-600 px-8 text-sm font-semibold text-white transition hover:bg-emerald-500 active:scale-95 flex items-center justify-center gap-2">
                                <span>Cari</span>
                            </button>
                        </form>
                    </div>
                    
                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 shadow-sm">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div x-show="toast.visible" x-transition.opacity class="fixed top-5 right-5 z-50 max-w-xs rounded-2xl px-4 py-3 text-sm font-medium text-white shadow-lg" :class="toast.type === 'success' ? 'bg-emerald-500' : 'bg-rose-500'" x-cloak>
                        <p x-text="toast.message"></p>
                    </div>
                    @if(session('error'))
                        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if($errors->any())
                        <div class="rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm text-rose-800 shadow-sm">
                            <ul class="list-inside list-disc">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Products Grid -->
                    <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3">
                        @forelse($products as $product)
                            <article class="group overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition duration-200 hover:shadow-xl flex flex-col w-full">
                                <!-- Image -->
                                <div class="relative h-44 overflow-hidden bg-gradient-to-br from-slate-100 to-slate-200 shrink-0">
                                    <img src="{{ $product->gambar_url ?? 'https://via.placeholder.com/400x300?text=Produk' }}" alt="{{ $product->nama_barang }}" loading="lazy" class="h-full w-full object-cover rounded-t-2xl" onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'" />
                                    <!-- Stock Badge -->
                                    <div class="absolute top-3 right-3">
                                        <span class="inline-flex rounded-lg bg-slate-900/85 px-2.5 py-1 text-xs font-semibold text-white shadow-sm">
                                            {{ $product->stok }} stok
                                        </span>
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex flex-col p-4 flex-1 justify-between gap-4">
                                    <div>
                                        <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Bahan Makanan</p>
                                        <h3 class="mt-1 text-sm font-semibold text-slate-900 line-clamp-2 leading-snug">{{ $product->nama_barang }}</h3>
                                        
                                        <!-- Price -->
                                        <p class="mt-2 text-lg font-bold text-emerald-600">
                                            Rp {{ number_format($product->harga, 0, ',', '.') }}
                                        </p>
                                    </div>

                                    <!-- Add Button -->
                                    <form x-on:submit.prevent="addToCart({{ $product->id }}, {{ $product->harga }})" class="mt-auto">
                                        @csrf
                                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-500 text-white py-2.5 rounded-xl transition duration-200 flex items-center justify-center gap-2 font-semibold text-sm active:scale-95 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                            </svg>
                                            Tambah
                                        </button>
                                    </form>
                                </div>
                            </article>
                        @empty
                            <div class="col-span-full rounded-xl border border-slate-200 bg-white p-12 text-center shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-14 w-14 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m-8-4v10M8 7v10m8-10v10" />
                                </svg>
                                <p class="mt-4 text-lg font-semibold text-slate-900">Produk tidak ditemukan</p>
                                <p class="mt-1 text-sm text-slate-500">Coba ubah pencarian Anda</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($products->hasPages())
                        <div class="mt-6 flex justify-center">
                            {{ $products->links() }}
                        </div>
                    @endif
                </section>

                <!-- Cart Sidebar -->
                <aside class="h-fit" id="cart-sidebar">
                    @include('transaksi.partials.cart_sidebar')
                </aside>
            </div>
        </div>

        <!-- Mobile Sticky Checkout -->
        <div x-show="cartCount > 0" x-cloak x-transition class="mobile-sticky-checkout fixed inset-x-0 bottom-0 z-50 border-t border-gray-200 bg-white shadow-[0_-4px_20px_rgba(0,0,0,0.08)] lg:hidden" style="padding-bottom: env(safe-area-inset-bottom); transition: transform .2s ease, opacity .2s ease;">
            <div class="flex items-center justify-between gap-3 w-full px-4 py-3">
                <div class="flex flex-col justify-center">
                    <p class="text-[10px] font-semibold uppercase tracking-[0.24em] text-slate-400">Total</p>
                    <p class="text-xl font-extrabold text-slate-900 -mt-0.5">Rp <span x-text="format(total)"></span></p>
                </div>
                <button @click.prevent="checkoutOpen = true; bayar = 0" class="inline-flex h-11 px-5 items-center justify-center rounded-xl bg-emerald-600 text-sm font-bold text-white shadow-sm shadow-emerald-600/20 hover:bg-emerald-500 active:scale-95 transition-all flex-shrink-0">
                    Lanjut Bayar
                </button>
            </div>
        </div>

        <!-- Checkout Modal -->
        <div x-show="checkoutOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-950/40 px-4" @keydown.escape.window="checkoutOpen = false">
            <div x-show="checkoutOpen" class="w-full max-w-md rounded-xl bg-white shadow-2xl border border-slate-200">
                <!-- Header -->
                <div class="flex items-center justify-between border-b border-slate-200 px-6 py-5">
                    <div>
                        <h2 class="text-xl font-bold text-slate-900">Proses Pembayaran</h2>
                        <p class="mt-1 text-xs text-slate-500">Masukkan nominal pembayaran</p>
                    </div>
                    <button type="button" @click="checkoutOpen = false" class="flex h-9 w-9 items-center justify-center rounded-lg bg-slate-100 text-slate-600 transition hover:bg-slate-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Body -->
                <form action="{{ route('transaksi.checkout') }}" method="POST" class="space-y-5 px-6 py-6" @submit="processing = true">
                    @csrf

                    <!-- Total Tagihan -->
                    <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-5">
                        <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Total Tagihan</p>
                        <p class="mt-3 text-4xl font-bold text-emerald-600">
                            Rp <span x-text="format(total)"></span>
                        </p>
                    </div>

                    <!-- Input Bayar -->
                    <div class="space-y-2">
                        <label for="bayar" class="text-sm font-semibold text-slate-900">Jumlah Bayar</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-lg font-semibold text-slate-400">Rp</span>
                            <input 
                                id="bayar" 
                                name="bayar" 
                                x-model.number="bayar" 
                                type="number" 
                                min="0" 
                                step="1000" 
                                placeholder="0" 
                                autofocus
                                @focus="$el.select()"
                                class="w-full rounded-lg border border-slate-300 bg-white pl-14 pr-4 py-4 text-right text-2xl font-bold text-slate-900 outline-none transition focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100" 
                            />
                        </div>
                    </div>

                    <!-- Summary -->
                    <div class="space-y-3 rounded-lg bg-slate-50 p-4 border border-slate-200">
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Total Tagihan</span>
                            <span class="font-semibold text-slate-900">Rp <span x-text="format(total)"></span></span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-slate-600">Jumlah Bayar</span>
                            <span class="font-semibold text-slate-900">Rp <span x-text="format(bayar)"></span></span>
                        </div>
                        <div class="border-t border-slate-200 pt-3 flex justify-between">
                            <span class="font-semibold text-slate-900">Kembalian</span>
                            <span class="text-lg font-bold" :class="bayar < total ? 'text-rose-600' : 'text-emerald-600'">
                                Rp <span x-text="bayar >= total ? format(change) : '0'"></span>
                            </span>
                        </div>
                    </div>

                    <!-- Warning -->
                    <template x-if="bayar < total">
                        <div class="rounded-lg border border-rose-200 bg-rose-50 px-4 py-3">
                            <p class="text-sm font-semibold text-rose-800">
                                Kurang Rp <span x-text="format(total - bayar)"></span>
                            </p>
                        </div>
                    </template>

                    <!-- Actions -->
                    <div class="flex gap-3 pt-2">
                        <button type="button" @click="checkoutOpen = false" class="flex-1 rounded-lg border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Batal
                        </button>
                        <button 
                            type="submit" 
                            :disabled="!isEnough || total === 0 || processing" 
                            :class="(!isEnough || total === 0 || processing) ? 'bg-slate-300 text-slate-600 cursor-not-allowed' : 'bg-emerald-600 text-white hover:bg-emerald-500'" 
                            class="flex-1 rounded-lg px-4 py-3 text-sm font-semibold transition active:scale-95 flex items-center justify-center gap-2"
                        >
                            <template x-if="processing">
                                <svg class="h-5 w-5 animate-spin" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 0110 10" opacity="0.3" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 2a10 10 0 0110 10" />
                                </svg>
                            </template>
                            <span x-text="processing ? 'Memproses...' : 'Selesaikan Pembayaran'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
