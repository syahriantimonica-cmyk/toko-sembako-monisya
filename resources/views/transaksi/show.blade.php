@extends('layouts.app')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between print-hidden">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">Detail Transaksi</h1>
                <p class="mt-1 text-sm text-slate-500">Kode {{ $transaction->kode_transaksi }}.</p>
            </div>
            <button onclick="window.print()" class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white transition duration-200 hover:bg-slate-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9V2h12v7m-6 5v6m-6-6h12" />
                </svg>
                Cetak Struk
            </button>
        </div>

        <div class="mx-auto w-full max-w-[320px] bg-white text-black font-mono text-[12px] leading-relaxed print:mx-0 print:shadow-none print:border-none receipt-print-area">
            <div class="border border-black/10 px-5 py-6">
                <div class="text-center">
                    <p class="text-sm tracking-[0.24em] uppercase text-black">Toko Sembako Monisya Mart</p>
                    <p class="mt-1 text-[10px] uppercase tracking-[0.24em] text-slate-700">Jl. Polindes No. 12</p>
                    <p class="text-[10px] uppercase tracking-[0.24em] text-slate-700">0812-3456-7890</p>
                </div>

                <div class="my-4 border-t border-dashed border-black/20 pt-3 text-[10px] text-slate-900">
                    <div class="flex justify-between">
                        <span>Tanggal</span>
                        <span>{{ $transaction->created_at->format('d-m-Y') }}</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>Jam</span>
                        <span>{{ $transaction->created_at->format('H:i') }}</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>Kasir</span>
                        <span>{{ $transaction->user->name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex justify-between mt-1">
                        <span>ID</span>
                        <span>{{ $transaction->kode_transaksi }}</span>
                    </div>
                </div>

                <div class="border-t border-dashed border-black/20 pt-3 text-[10px] text-slate-900">
                    @foreach($transaction->items as $item)
                        <div class="mb-3">
                            <div class="flex justify-between">
                                <span class="font-semibold text-[11px]">{{ Str::limit($item->product->nama_barang ?? 'Produk tidak ditemukan', 26, '') }}</span>
                                <span class="font-semibold text-[11px]">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                            <div class="mt-1 flex justify-between text-[10px] text-slate-700">
                                <span>{{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                                <span></span>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-2 border-t border-dashed border-black/20 pt-3 text-[11px] text-slate-900">
                    <div class="flex justify-between py-1">
                        <span>Total</span>
                        <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1">
                        <span>Bayar</span>
                        <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between py-1 text-sm font-bold">
                        <span>Kembalian</span>
                        <span>Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                    </div>
                </div>

                <div class="mt-4 border-t border-dashed border-black/20 pt-3 text-center text-[10px] text-slate-700">
                    <p>Terima kasih</p>
                    <p class="mt-1">Simpan struk ini sebagai bukti pembayaran</p>
                </div>
            </div>
        </div>

        <div class="print-hidden">
            <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                <div class="px-6 py-5 border-b border-slate-200 bg-slate-50">
                    <p class="text-sm uppercase tracking-[0.24em] text-slate-500">Daftar Item</p>
                </div>
                <div class="space-y-4 p-6">
                    @foreach($transaction->items as $item)
                        <div class="grid gap-4 rounded-3xl border border-slate-200 bg-slate-50 p-4 md:grid-cols-[1fr_auto]">
                            <div>
                                <p class="font-semibold text-slate-900">{{ $item->product->nama_barang ?? 'Produk tidak ditemukan' }}</p>
                                <p class="mt-2 text-sm text-slate-600">Qty: {{ $item->qty }} x Rp {{ number_format($item->harga, 0, ',', '.') }}</p>
                            </div>
                            <p class="text-right text-sm font-semibold text-slate-900">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-4 lg:grid-cols-[1fr_0.55fr]">
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <h2 class="text-xl font-semibold text-slate-900">Catatan Transaksi</h2>
                    <p class="mt-3 text-sm text-slate-500">Transaksi disimpan dengan detail lengkap. Gunakan tombol cetak untuk menerima struk kasir.</p>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Total</span>
                            <span>Rp {{ number_format($transaction->total, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm text-slate-600">
                            <span>Bayar</span>
                            <span>Rp {{ number_format($transaction->bayar, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex items-center justify-between text-sm font-semibold text-slate-900">
                            <span>Kembalian</span>
                            <span>Rp {{ number_format($transaction->kembalian, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                margin: 0 !important;
                background: #fff !important;
            }
            .print-hidden {
                display: none !important;
            }
            body * {
                visibility: hidden;
            }
            .receipt-print-area,
            .receipt-print-area * {
                visibility: visible;
            }
            .receipt-print-area {
                position: absolute;
                left: 50%;
                top: 0;
                transform: translateX(-50%);
                width: 320px;
                max-width: 320px;
                margin: 0;
                box-shadow: none !important;
            }
            @page {
                size: 80mm auto;
                margin: 5mm;
            }
        }
    </style>
@endsection
