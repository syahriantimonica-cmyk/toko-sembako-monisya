@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Detail Transaksi: ') . $transaction->kode_transaksi }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-6 text-gray-900">
                <!-- Header Actions -->
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-slate-900">Informasi Transaksi</h3>
                        <p class="text-sm text-slate-500">Detail lengkap transaksi {{ $transaction->kode_transaksi }}</p>
                    </div>
                    <div class="flex gap-3">
                        <button onclick="window.print()" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-colors">
                            Print Struk
                        </button>
                        <a href="{{ route('laporan.exportDetailPdf', $transaction->id) }}" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            Export PDF
                        </a>
                    </div>
                </div>

                <!-- Transaction Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="bg-slate-50 rounded-xl p-4">
                        <h4 class="font-medium text-slate-900 mb-3">Informasi Dasar</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-slate-600">Kode Transaksi:</span>
                                <span class="font-medium">{{ $transaction->kode_transaksi }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Tanggal:</span>
                                <span class="font-medium">{{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-slate-600">Kasir:</span>
                                <span class="font-medium">{{ $transaction->user->name }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-emerald-50 rounded-xl p-4">
                        <h4 class="font-medium text-emerald-900 mb-3">Ringkasan Pembayaran</h4>
                        <div class="space-y-2">
                            <div class="flex justify-between">
                                <span class="text-emerald-700">Total:</span>
                                <span class="font-medium text-emerald-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-emerald-700">Bayar:</span>
                                <span class="font-medium text-emerald-900">Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-emerald-700">Kembalian:</span>
                                <span class="font-medium text-emerald-900">Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Items Table -->
                <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                    <div class="px-6 py-4 bg-slate-50 border-b border-slate-200">
                        <h4 class="font-medium text-slate-900">Daftar Item</h4>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-200">
                            <thead class="bg-slate-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Produk</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Qty</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Harga</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-200">
                                @foreach($transaction->items as $item)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                        {{ $item->product->nama }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                        {{ $item->qty }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                        Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="mt-6">
                    <a href="{{ route('laporan.index') }}" class="inline-flex items-center px-4 py-2 bg-slate-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-slate-700 focus:bg-slate-700 active:bg-slate-900 focus:outline-none focus:ring-2 focus:ring-slate-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Kembali ke Laporan
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Print Styles -->
<style media="print">
    @page {
        size: 80mm auto;
        margin: 0;
    }
    body {
        font-size: 12px;
        line-height: 1.2;
    }
    .no-print {
        display: none !important;
    }
    .bg-white {
        background: white !important;
    }
    .shadow-sm {
        box-shadow: none !important;
    }
    .rounded-2xl {
        border-radius: 0 !important;
    }
</style>
@endsection