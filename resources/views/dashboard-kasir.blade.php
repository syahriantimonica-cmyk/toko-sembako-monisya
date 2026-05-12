<x-app-layout>

    <div class="space-y-4 md:space-y-6 pt-4 md:pt-6 w-full">
        <div class="rounded-3xl border border-slate-100 bg-white px-4 md:px-8 py-4 md:py-6 shadow-sm mb-4 md:mb-6 w-full">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-3xl font-bold text-slate-800">Dashboard Kasir</h1>
                    <p class="mt-1 text-sm text-slate-500">Sistem kasir modern untuk kemudahan pelayanan</p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 text-sm text-slate-500">
                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-sm font-medium text-emerald-700">Kasir</span>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                        <span id="tanggal"></span>
                        <span class="hidden sm:inline">|</span>
                        <span id="clock" class="font-medium text-slate-700"></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="space-y-4 md:space-y-6 w-full">
        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
            <!-- Transaksi Hari Ini -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Transaksi Hari Ini</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['transactions_today'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">Jumlah transaksi</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-emerald-100">
                        <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Hari Ini -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pendapatan Hari Ini</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Total penjualan</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Item Terjual Hari Ini -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Item Terjual</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['items_sold_today'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">Total item hari ini</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="grid gap-4 md:grid-cols-2">
            <a href="{{ route('transaksi.index') }}" class="flex items-center justify-between rounded-xl border border-emerald-200 bg-emerald-50 px-5 py-4 transition hover:bg-emerald-100">
                <div>
                    <div class="text-sm font-bold text-emerald-900">Mulai Transaksi Baru</div>
                    <div class="mt-0.5 text-xs text-emerald-700">Buat transaksi POS baru</div>
                </div>
                <svg class="h-5 w-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>

            <a href="{{ route('transaksi.history') }}" class="flex items-center justify-between rounded-xl border border-slate-200 bg-slate-50 px-5 py-4 transition hover:bg-slate-100">
                <div>
                    <div class="text-sm font-bold text-slate-900">Lihat Riwayat Transaksi</div>
                    <div class="mt-0.5 text-xs text-slate-600">Riwayat penjualan Anda</div>
                </div>
                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
            </a>
        </div>

        <!-- Info Section -->
        <div class="grid gap-4 lg:grid-cols-2">
            <!-- Store Info -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Informasi Toko</h3>
                <div class="space-y-2">
                    <div class="rounded-lg bg-slate-50 px-3 py-3 border border-slate-200">
                        <div class="text-xs font-medium text-slate-600 uppercase tracking-wider">Nama Toko</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">Toko Sembako Monisya Mart</div>
                    </div>
                    <div class="rounded-lg bg-slate-50 px-3 py-3 border border-slate-200">
                        <div class="text-xs font-medium text-slate-600 uppercase tracking-wider">Jam Operasional</div>
                        <div class="mt-1 text-sm font-semibold text-slate-900">Senin - Minggu: 06:00 - 20:00</div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Aktivitas Hari Ini</h3>
                <ul class="space-y-2">
                    @forelse($todayTransactions as $transaction)
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 border border-slate-200">
                        <div>
                            <div class="text-xs font-medium text-slate-900">{{ $transaction->kode_transaksi }}</div>
                            <div class="text-xs text-slate-500">Rp {{ number_format($transaction->total, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($transaction->created_at)->format('H:i') }}</div>
                    </li>
                    @empty
                    <li class="text-center py-6 text-xs text-slate-500">Belum ada transaksi hari ini</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <script>
        function updateClock() {
            const now = new Date();
            const time = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit'
            }).format(now);
            const date = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            }).format(now);
            document.getElementById('clock').innerText = time + ' WIB';
            document.getElementById('tanggal').innerText = date;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</x-app-layout>
