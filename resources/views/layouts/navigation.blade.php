<aside 
class="hidden lg:flex fixed inset-y-0 left-0 w-72 flex-col text-white border-r"
style="background:#0f172a; border-color:#1e3a8a;">

    <!-- HEADER -->
    <div class="px-6 py-6 border-b"
         style="border-color:#1e3a8a;">

        <div class="flex items-center gap-3 mb-2">

            <!-- LOGO -->
            <div class="flex h-10 w-10 items-center justify-center rounded-xl shadow-lg"
                 style="background:linear-gradient(to bottom right,#3b82f6,#2563eb);">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6 text-white"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>

            <!-- NAMA TOKO -->
            <div class="flex-1">
                <p class="text-sm font-bold tracking-tight text-white">
                    Toko Bahan
                </p>

                <p class="text-xs font-medium"
                   style="color:#93c5fd;">
                    Makanan
                </p>
            </div>
        </div>

        <p class="text-xs mt-2 px-1"
           style="color:#cbd5e1;">
            Sistem POS Modern
        </p>
    </div>

    <!-- USER INFO -->
    <div class="px-4 py-4 border-b"
         style="border-color:#1e3a8a;">

        <div class="rounded-xl px-4 py-3 border"
             style="background:#1e293b; border-color:#1e3a8a;">

            <p class="font-semibold text-white truncate text-sm">
                {{ Auth::user()->name }}
            </p>

            <p class="mt-2 inline-block rounded-full px-2.5 py-1 text-xs font-medium capitalize"
               style="background:#1d4ed8; color:white;">
                {{ Auth::user()->role === 'admin' ? 'Administrator' : 'Kasir' }}
            </p>
        </div>

        <!-- LOGOUT -->
        <form method="POST"
              action="{{ route('logout') }}"
              class="mt-3">
            @csrf

            <button type="submit"
                    class="flex w-full items-center justify-center gap-2 rounded-xl px-3 py-2.5 text-sm font-medium text-white transition"
                    style="background:#2563eb;">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>

                <span>Keluar</span>
            </button>
        </form>
    </div>

    <!-- MENU -->
    <div class="flex-1 overflow-y-auto px-4 py-5">

        <div class="space-y-2">

            <!-- MENU ADMIN -->
            @if(auth()->user()->role === 'admin')

                <div class="mb-3">
                    <p class="text-xs font-bold uppercase tracking-wider px-3 mb-2"
                       style="color:#93c5fd;">
                        Menu Admin
                    </p>
                </div>

                <!-- DASHBOARD -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('dashboard') || request()->routeIs('dashboard.admin')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Dashboard</span>
                </a>

                <!-- PRODUK -->
                <a href="{{ route('products.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('products.*')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Produk</span>
                </a>

                <!-- KELOLA STOK -->
                <a href="{{ route('stok.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('stok.*')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Kelola Stok</span>
                </a>

                <!-- LAPORAN -->
                <a href="{{ route('laporan.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('laporan.*')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Laporan</span>
                </a>

                <!-- RIWAYAT -->
                <a href="{{ route('transaksi.history') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('transaksi.history')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Riwayat</span>
                </a>

            <!-- MENU KASIR -->
            @elseif(auth()->user()->role === 'kasir')

                <div class="mb-3">
                    <p class="text-xs font-bold uppercase tracking-wider px-3 mb-2"
                       style="color:#93c5fd;">
                        Menu Kasir
                    </p>
                </div>

                <!-- DASHBOARD -->
                <a href="{{ route('dashboard') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('dashboard') || request()->routeIs('dashboard.kasir')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Dasbor</span>
                </a>

                <!-- TRANSAKSI -->
                <a href="{{ route('transaksi.index') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('transaksi.index')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Transaksi POS</span>
                </a>

                <!-- RIWAYAT -->
                <a href="{{ route('transaksi.history') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('transaksi.history')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Riwayat Saya</span>
                </a>

            @endif

            <!-- PROFIL -->
            <div class="mt-6 pt-4 border-t"
                 style="border-color:#1e3a8a;">

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-medium transition"

                   style="{{ request()->routeIs('profile.*')
                   ? 'background:#2563eb; color:white;'
                   : 'color:#e2e8f0;' }}">

                    <span>Profil</span>
                </a>
            </div>

        </div>
    </div>

</aside>