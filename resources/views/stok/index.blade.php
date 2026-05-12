@extends('layouts.app')

@section('content')
    <div class="space-y-4 md:space-y-6 w-full">
        <div class="rounded-2xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm w-full">
            <div class="flex flex-col gap-1 md:gap-2">
                <h1 class="text-xl md:text-3xl font-semibold text-slate-900">Kelola Stok</h1>
                <p class="text-xs md:text-sm text-slate-500">Pantau dan perbarui stok produk secara langsung.</p>
            </div>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm w-full">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4 md:mb-6">
                <form method="GET" class="flex-1 min-w-0">
                    <label for="search" class="sr-only">Cari produk</label>
                    <div class="relative">
                        <input id="search" name="search" value="{{ $search }}" placeholder="Cari produk..."
                               class="w-full rounded-full border border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 px-4 py-2 pl-11 focus:border-emerald-500 focus:ring-emerald-500"
                               autocomplete="off" />
                        <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <div class="flex flex-wrap gap-2">
                    @foreach(['all' => 'Semua', 'aman' => 'Aman', 'menipis' => 'Menipis', 'kritis' => 'Kritis'] as $value => $label)
                        <a href="{{ route('stok.index', array_merge(request()->except('page'), ['filter' => $value])) }}"
                           class="inline-flex items-center rounded-full px-4 py-2 text-sm font-medium transition {{ $filter === $value ? 'bg-emerald-600 text-white' : 'bg-slate-100 text-slate-700 hover:bg-slate-200' }}">
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-700 mb-6">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                <table class="min-w-[760px] divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Gambar</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Produk</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Stok Sekarang</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Status Stok</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-200">
                        @forelse($products as $product)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->gambar)
                                        <img src="{{ $product->gambar_url }}" alt="{{ $product->nama_barang }}" class="h-14 w-14 rounded-2xl object-cover border border-slate-200" onerror="this.src='https://via.placeholder.com/300'" />
                                    @else
                                        <img src="https://via.placeholder.com/300" alt="No image" class="h-14 w-14 rounded-2xl object-cover border border-slate-200" />
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $product->nama_barang }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->stok }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->stok > 20)
                                        <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">AMAN</span>
                                    @elseif($product->stok >= 5)
                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-amber-700">MENIPIS</span>
                                    @else
                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-red-700">KRITIS</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form method="POST" action="{{ route('stok.update', $product) }}" class="space-y-3">
                                        @csrf
                                        @method('PATCH')
                                        <div class="grid gap-2 sm:grid-cols-2">
                                            <label class="sr-only" for="add_stock_{{ $product->id }}">Tambah stok</label>
                                            <input id="add_stock_{{ $product->id }}" name="add_stock" type="number" min="0" value="0"
                                                   class="w-full rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 focus:border-emerald-500 focus:ring-emerald-500"
                                                   placeholder="Tambah stok" />

                                            <label class="sr-only" for="reduce_stock_{{ $product->id }}">Kurangi stok</label>
                                            <input id="reduce_stock_{{ $product->id }}" name="reduce_stock" type="number" min="0" value="0"
                                                   class="w-full rounded-full border border-slate-200 bg-slate-50 px-3 py-2 text-sm text-slate-900 focus:border-amber-500 focus:ring-amber-500"
                                                   placeholder="Kurangi stok" />
                                        </div>
                                        <button type="submit" class="inline-flex w-full items-center justify-center rounded-full bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition hover:bg-slate-800">Update</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-slate-500">
                                    <div class="space-y-3">
                                        <svg class="mx-auto h-12 w-12 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                        </svg>
                                        <div class="space-y-1">
                                            <p class="text-sm font-semibold text-slate-900">Tidak ada produk yang sesuai.</p>
                                            <p class="text-sm text-slate-500">Coba ubah kata kunci pencarian atau filter stok.</p>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
