@extends('layouts.app')

@section('content')
    <div class="space-y-4 md:space-y-6 w-full">
        <div class="rounded-3xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm w-full">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-2xl font-semibold text-slate-900">Riwayat Transaksi</h1>
                    <p class="mt-1 text-sm text-slate-500">Daftar transaksi terakhir dan detail penjualan.</p>
                </div>
                <form action="{{ route('transaksi.history') }}" method="GET" class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <input type="search" name="search" value="{{ request('search') }}" placeholder="Cari kode atau kasir..." class="rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-100" />
                    <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-emerald-600 px-5 py-3 text-sm font-semibold text-white hover:bg-emerald-500">Cari</button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-3xl border border-emerald-200 bg-emerald-50 px-6 py-4 text-slate-900 shadow-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto rounded-3xl border border-slate-200 bg-white shadow-sm w-full">
            <table class="min-w-full divide-y divide-slate-200">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Kode</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Tanggal</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Kasir</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Total</th>
                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-[0.24em] text-slate-500">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200 bg-white">
                    @forelse($transactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">{{ $transaction->kode_transaksi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $transaction->created_at->format('d M Y H:i') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $transaction->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-semibold text-slate-900">Rp {{ number_format($transaction->total, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="{{ route('transaksi.show', $transaction) }}" class="inline-flex items-center rounded-3xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800 mr-2">Detail</a>
                                <form method="POST" action="{{ route('transaksi.destroy', $transaction) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center rounded-3xl bg-red-600 px-4 py-2 text-sm font-semibold text-white hover:bg-red-500">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">Belum ada transaksi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white p-4 md:p-6 shadow-sm w-full">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
@endsection
