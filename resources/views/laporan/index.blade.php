@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Laporan Transaksi') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl">
            <div class="p-6 text-gray-900">
                <!-- Filter dan Search -->
                <div class="mb-6 flex flex-col sm:flex-row gap-4">
                    <form method="GET" class="flex flex-col sm:flex-row gap-4 flex-1">
                        <!-- Filter -->
                        <div class="flex gap-2">
                            <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors {{ !request()->has('filter') ? 'bg-slate-200' : '' }}">
                                Semua
                            </a>
                            <a href="{{ route('laporan.index', ['filter' => 'harian']) }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors {{ request('filter') == 'harian' ? 'bg-slate-200' : '' }}">
                                Harian
                            </a>
                            <a href="{{ route('laporan.index', ['filter' => 'bulanan']) }}" class="px-4 py-2 bg-slate-100 text-slate-700 rounded-lg hover:bg-slate-200 transition-colors {{ request('filter') == 'bulanan' ? 'bg-slate-200' : '' }}">
                                Bulanan
                            </a>
                        </div>

                        <!-- Search -->
                        <div class="flex-1">
                            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari kode transaksi atau nama kasir..." class="w-full px-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        </div>

                        <button type="submit" class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                            Cari
                        </button>
                    </form>

                    <!-- Export PDF -->
                    <a href="{{ route('laporan.exportPdf', request()->query()) }}" class="px-6 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                        Export PDF
                    </a>

                    <!-- Clear All Except Admin -->
                    <form method="POST" action="{{ route('laporan.clearAllExceptAdmin') }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua transaksi kecuali yang dibuat oleh admin?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                            Kosongkan Semua Kecuali Admin
                        </button>
                    </form>
                </div>

                <!-- Tabel Transaksi -->
                @if($transactions->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kode Transaksi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Kasir</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Jumlah Item</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-slate-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-slate-200">
                            @foreach($transactions as $transaction)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    {{ $transaction->kode_transaksi }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ \Carbon\Carbon::parse($transaction->created_at)->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $transaction->user->name }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-500">
                                    {{ $transaction->items->sum('qty') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    Rp {{ number_format($transaction->total, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="{{ route('laporan.detail', $transaction->id) }}" class="text-emerald-600 hover:text-emerald-900 transition-colors mr-3">
                                        Detail
                                    </a>
                                    <form method="POST" action="{{ route('laporan.destroy', $transaction->id) }}" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $transactions->appends(request()->query())->links() }}
                </div>
                @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-slate-900">Belum ada data laporan</h3>
                    <p class="mt-1 text-sm text-slate-500">Transaksi akan muncul di sini setelah ada aktivitas penjualan.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection