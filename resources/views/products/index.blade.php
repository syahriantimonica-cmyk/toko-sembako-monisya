@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[32px] border border-white/10 bg-slate-900/80 p-6 shadow-2xl shadow-slate-950/40 backdrop-blur-lg">
            <div class="flex flex-col gap-2">
                <h2 class="text-3xl font-semibold tracking-tight text-white">Kelola Barang</h2>
                <p class="text-sm text-slate-400">Daftar semua barang Barang toko Monisya Mart.</p>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm p-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">
                <form method="GET" class="flex-1 min-w-0">
                    <div class="relative">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Cari barang..."
                               class="w-full rounded-2xl border border-slate-200 bg-slate-50 text-slate-900 placeholder:text-slate-400 px-4 py-3 pl-11 focus:border-emerald-500 focus:ring-emerald-500" />
                        <svg class="absolute left-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>

                <a href="{{ route('products.create') }}"
                   class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-700 sm:w-auto">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Barang
                </a>
            </div>

            @if(session('success'))
                <div class="rounded-2xl border border-emerald-200 bg-emerald-50 p-4 text-emerald-700 mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if($products->count())
                <div class="space-y-4 lg:hidden">
                    @foreach($products as $product)
                        <article class="overflow-hidden rounded-3xl border border-slate-200 bg-slate-50 shadow-sm">
                            <div class="flex flex-col gap-4 p-4 sm:flex-row sm:items-start">
                                <img src="{{ $product->gambar_url ?? 'https://via.placeholder.com/400x300?text=Produk' }}" alt="{{ $product->nama_barang }}" loading="lazy" class="h-40 w-full rounded-3xl object-cover sm:w-36" onerror="this.src='https://via.placeholder.com/400x300?text=No+Image'" />
                                <div class="flex-1 space-y-3">
                                    <div>
                                        <p class="text-xs uppercase tracking-[0.24em] text-slate-500">Toko Sembako</p>
                                        <h3 class="mt-1 text-lg font-semibold text-slate-900 line-clamp-2">{{ $product->nama_barang }}</h3>
                                    </div>
                                    <div class="flex flex-col gap-2 text-sm text-slate-700">
                                        <span>Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
                                        <span>{{ $product->stok }} stok tersedia</span>
                                    </div>
                                    <div class="grid gap-2 sm:grid-cols-2">
                                        <a href="{{ route('products.edit', $product) }}" class="inline-flex h-12 items-center justify-center rounded-2xl bg-slate-900 text-white text-sm font-semibold transition hover:bg-slate-800">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?')" class="inline-flex h-12 w-full items-center justify-center rounded-2xl bg-rose-100 text-rose-700 text-sm font-semibold transition hover:bg-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="hidden lg:block overflow-x-auto rounded-2xl border border-slate-200">
                    <table class="min-w-[720px] divide-y divide-slate-200 bg-white">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Gambar</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Nama Barang</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Harga</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Stok</th>
                                <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200">
                            @foreach($products as $product)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <img src="{{ $product->gambar_url ?? 'https://via.placeholder.com/400x300?text=Produk' }}" alt="{{ $product->nama_barang }}" class="h-12 w-12 rounded-lg object-cover border border-slate-200" onerror="this.src='https://via.placeholder.com/300'" />
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $product->nama_barang }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-900">{{ $product->stok }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('products.edit', $product) }}" class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-200 transition text-sm">
                                                Edit
                                            </a>
                                            <form method="POST" action="{{ route('products.destroy', $product) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus barang ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center px-3 py-1 rounded-full bg-rose-100 text-rose-700 hover:bg-rose-200 transition text-sm">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="rounded-2xl border border-slate-200 bg-slate-50 p-12 text-center">
                    <svg class="mx-auto h-14 w-14 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <div class="mt-4 space-y-2">
                        <p class="text-lg font-semibold text-slate-900">Belum ada barang.</p>
                        <p class="text-sm text-slate-500">Tambahkan produk pertama Anda sekarang.</p>
                        <a href="{{ route('products.create') }}" class="inline-flex items-center justify-center rounded-2xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-emerald-700 transition">
                            Tambah Barang
                        </a>
                    </div>
                </div>
            @endif

            @if($products->hasPages())
                <div class="mt-6 flex justify-center">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
