<x-app-layout>

    <div class="space-y-4 md:space-y-6 pt-4 md:pt-6 w-full">
        <div class="rounded-3xl border border-slate-100 bg-white px-4 md:px-8 py-4 md:py-6 shadow-sm mb-4 md:mb-6 w-full">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                <div class="min-w-0">
                    <h1 class="text-3xl font-bold text-slate-800">Dashboard Admin</h1>
                    <p class="mt-1 text-sm text-slate-500">Kelola toko dan monitor aktivitas penjualan</p>
                </div>
                <div class="flex flex-col sm:flex-row sm:items-center gap-3 text-sm text-slate-500">
                    <span class="inline-flex rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-700">Admin</span>
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
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">
            <!-- Total User -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total User</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_users'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">Pengguna terdaftar</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-100">
                        <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m6 0H9m3-8h.01M9 12h.01M15 12h.01M9 16h.01M15 16h.01M12 20h.01"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Barang -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Barang</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_products'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">Barang di toko Monisya Mart</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-primary-100">
                        <svg class="h-5 w-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4m0 0l8 4M4 7v10a1 1 0 001 1h14a1 1 0 001-1V7m-8-4v4"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Total Transaksi -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Total Transaksi</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">{{ $stats['total_transactions'] }}</p>
                        <p class="mt-1 text-xs text-slate-500">Semua transaksi</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-purple-100">
                        <svg class="h-5 w-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Pendapatan Hari Ini -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm transition-shadow duration-200 hover:shadow">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-medium text-slate-500 uppercase tracking-wider">Pendapatan Hari Ini</p>
                        <p class="mt-2 text-2xl font-bold text-slate-900">Rp {{ number_format($stats['revenue_today'], 0, ',', '.') }}</p>
                        <p class="mt-1 text-xs text-slate-500">Penjualan hari ini</p>
                    </div>
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-orange-100">
                        <svg class="h-5 w-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.646 7.23a2 2 0 01-1.789 1.106H7a2 2 0 01-2-2V9a6 6 0 0112 0z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid gap-4 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Transaksi 7 Hari Terakhir</h3>
                </div>
                <canvas id="transactionChart" height="200"></canvas>
            </div>

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900">Pendapatan 7 Hari Terakhir</h3>
                </div>
                <canvas id="revenueChart" height="200"></canvas>
            </div>
        </div>

        <!-- Menu & Activity -->
        <div class="grid gap-4 lg:grid-cols-2">
            <!-- Menu Management -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Menu Kelola Aplikasi</h3>
                <div class="space-y-2">
                    <a href="{{ route('products.index') }}" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 transition hover:bg-primary-50 hover:border-primary-200">
                        <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8-4m0 0l8 4M4 7v10a1 1 0 001 1h14a1 1 0 001-1V7m-8-4v4"></path></svg>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-slate-900">Kelola Produk</div>
                            <div class="text-xs text-slate-500">Tambah, edit, hapus produk</div>
                        </div>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('stok.index') }}" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 transition hover:bg-primary-50 hover:border-primary-200">
                        <svg class="h-4 w-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M7 11h10M9 15h6M6 5v14a2 2 0 002 2h8a2 2 0 002-2V5M6 5h12"></path></svg>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-slate-900">Kelola Stok</div>
                            <div class="text-xs text-slate-500">Pantau inventori real-time</div>
                        </div>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>

                    <a href="{{ route('laporan.index') }}" class="flex items-center gap-3 rounded-lg border border-slate-200 bg-slate-50 px-4 py-3 transition hover:bg-blue-50 hover:border-blue-200">
                        <svg class="h-4 w-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-slate-900">Laporan</div>
                            <div class="text-xs text-slate-500">Kumpulan laporan penjualan</div>
                        </div>
                        <svg class="h-4 w-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h3 class="text-sm font-bold text-slate-900 mb-4">Aktivitas Terbaru</h3>
                <ul class="space-y-2">
                    @forelse($recentTransactions as $transaction)
                    <li class="flex items-center justify-between rounded-lg bg-slate-50 px-3 py-2 border border-slate-200">
                        <div>
                            <div class="text-xs font-medium text-slate-900">{{ $transaction->kode_transaksi }}</div>
                            <div class="text-xs text-slate-500">oleh {{ $transaction->user->name }}</div>
                        </div>
                        <div class="text-xs text-slate-400">{{ \Carbon\Carbon::parse($transaction->created_at)->diffForHumans() }}</div>
                    </li>
                    @empty
                    <li class="text-center py-6 text-xs text-slate-500">Belum ada transaksi terbaru</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk grafik transaksi 7 hari terakhir

        const transactionCtx = document.getElementById('transactionChart').getContext('2d');
        new Chart(transactionCtx, {
            type: 'line',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: @json($transactionData),
                    borderColor: '#4311c1',
                    backgroundColor: 'rgba(37, 68, 221, 0.1)',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#4311c1',
                    pointBorderColor: 'rgba(37, 68, 221, 0.1)',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: { size: 11 }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: @json($revenueData),
                    backgroundColor: '#4311c1',
                    borderColor: '#3700b3',
                    borderWidth: 0,
                    borderRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: { size: 11 },
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Realtime Clock WIB
        function updateClock() {
            const now = new Date();
            const time = new Intl.DateTimeFormat('id-ID', {
                timeZone: 'Asia/Jakarta',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
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
