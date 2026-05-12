<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Dashboard</h1>
            <p class="mt-1 text-sm text-slate-600">
                @if(auth()->user()->role === 'admin')
                    Kelola aplikasi Toko Sembako  dengan mudah.
                @else
                    Sistem kasir modern untuk kemudahan pelayanan.
                @endif
            </p>
        </div>
    </x-slot>

    <!-- Redirect to role-specific dashboard -->
    @if(auth()->user()->role === 'admin')
        <script>
            window.location.href = "{{ route('dashboard.admin', [], false) }}";
        </script>
    @elseif(auth()->user()->role === 'kasir')
        <script>
            window.location.href = "{{ route('dashboard.kasir', [], false) }}";
        </script>
    @else
        <!-- Fallback for other roles -->
        <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm text-center">
            <h2 class="text-lg font-semibold text-slate-900 mb-2">Selamat Datang!</h2>
            <p class="text-slate-600">Monisya Mart toko sembako kami siap melayani Anda.</p>
        </div>
    @endif
</x-app-layout>
