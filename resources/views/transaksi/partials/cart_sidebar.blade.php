<div class="sticky top-6 space-y-4 rounded-xl border border-slate-200 bg-white p-5 shadow-sm" data-cart-summary-count="{{ $cartCount }}" data-cart-summary-total="{{ $cartTotal }}">
    <!-- Header -->
    <div>
        <p class="text-xs font-semibold uppercase tracking-wider text-slate-600">Ringkasan</p>
        <h2 class="mt-1 text-lg font-bold text-slate-900">Keranjang Anda</h2>
    </div>

    <!-- Cart Items -->
    @if(count($cart) === 0)
        <div class="rounded-lg border border-dashed border-slate-200 bg-slate-50 py-8 px-4 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-10 w-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 7M7 13l-2 9h14l-2-9m-4-5a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            <p class="mt-3 text-sm font-semibold text-slate-900">Keranjang kosong</p>
            <p class="mt-1 text-xs text-slate-500">Tambahkan produk untuk mulai</p>
        </div>
    @else
        <div class="space-y-3 max-h-80 overflow-y-auto pr-2">
            @foreach($cart as $item)
                <div class="flex flex-col sm:flex-row gap-3 rounded-lg border border-slate-100 bg-slate-50 p-3 transition-all duration-200">
                    <!-- Image -->
                    <img src="{{ $item['gambar_url'] ?? 'https://via.placeholder.com/60x60' }}" alt="{{ $item['nama_barang'] }}" class="h-16 w-16 sm:h-14 sm:w-14 rounded-lg object-cover border border-slate-200 shrink-0" onerror="this.src='https://via.placeholder.com/60x60'" />
                    
                    <!-- Content -->
                    <div class="flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="text-sm sm:text-xs font-bold text-slate-900 line-clamp-2">{{ $item['nama_barang'] }}</h3>
                            <p class="mt-1 text-xs font-medium text-slate-500">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                        </div>
                        
                        <!-- Actions & Subtotal -->
                        <div class="mt-3 sm:mt-2 flex items-center justify-between">
                            <!-- Qty Controls -->
                            <div class="flex items-center gap-1 bg-white rounded-lg border border-slate-200 p-0.5 shadow-sm">
                                <button type="button" @click.prevent="updateCartItem({{ $item['product_id'] }}, {{ $item['qty'] - 1 }})" :disabled="processing" class="h-9 w-9 rounded-md bg-white text-slate-700 hover:bg-slate-100 disabled:opacity-50 transition-all flex items-center justify-center active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" /></svg>
                                </button>
                                <input type="number" value="{{ $item['qty'] }}" min="1" readonly class="h-9 w-12 border-0 bg-transparent text-center text-sm font-bold text-slate-900 focus:ring-0 p-0" />
                                <button type="button" @click.prevent="updateCartItem({{ $item['product_id'] }}, {{ $item['qty'] + 1 }})" :disabled="processing" class="h-9 w-9 rounded-md bg-white text-slate-700 hover:bg-slate-100 disabled:opacity-50 transition-all flex items-center justify-center active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                                </button>
                            </div>

                            <div class="flex items-center gap-2">
                                <!-- Subtotal -->
                                <p class="text-sm font-bold text-emerald-600">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                <!-- Delete -->
                                <button type="button" @click.prevent="removeCartItem({{ $item['product_id'] }})" :disabled="processing" class="h-9 w-9 flex items-center justify-center rounded-md border border-rose-100 bg-rose-50 text-rose-600 hover:bg-rose-100 disabled:opacity-50 transition-all active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Summary -->
        <div class="border-t border-slate-200 pt-4 space-y-2 mt-4">
            <div class="flex justify-between text-xs text-slate-600">
                <span>Total Item</span>
                <span class="font-semibold text-slate-900">{{ $cartCount }}</span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-sm font-bold text-slate-900">Total Bayar</span>
                <span class="text-xl font-bold text-emerald-600">Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Checkout Button -->
        <button @click.prevent="checkoutOpen = true; bayar = 0" type="button" class="w-full h-12 rounded-xl bg-emerald-600 text-sm font-bold text-white transition hover:bg-emerald-500 active:scale-95 shadow-sm shadow-emerald-500/20 flex items-center justify-center gap-2 mt-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h10m4 0a2 2 0 11-4 0 2 2 0 014 0zm-8 0a2 2 0 11-4 0 2 2 0 014 0z" />
            </svg>
            Checkout Sekarang
        </button>
    @endif
</div>
