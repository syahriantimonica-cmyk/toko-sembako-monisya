<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-white">Daftar Akun Baru</h1>
        <p class="mt-2 text-sm text-slate-400">Gunakan dashboard kasir modern untuk mengelola transaksi toko.</p>
    </div>

    <x-auth-validation-errors class="mb-4 rounded-2xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-100" :errors="$errors" />

    <form x-data="{ showPassword: false, showConfirm: false, submitting: false }" @submit="submitting = true" method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <div class="space-y-2">
            <label for="name" class="block text-sm font-medium text-slate-200">Nama</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="h-14 w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 text-white placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500/20 focus:outline-none" />
            <p class="mt-2 text-sm text-red-400">{{ $errors->first('name') }}</p>
        </div>

        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-slate-200">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
                   class="h-14 w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 text-white placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500/20 focus:outline-none" />
            <p class="mt-2 text-sm text-red-400">{{ $errors->first('email') }}</p>
        </div>

        <div class="space-y-2">
            <label for="password" class="block text-sm font-medium text-slate-200">Password</label>
            <div class="relative">
                <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required autocomplete="new-password"
                       class="h-14 w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 pr-12 text-white placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500/20 focus:outline-none" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-3 inline-flex items-center text-slate-400 transition hover:text-white">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8 .9-1.76 2.18-3.29 3.79-4.51" />
                        <path d="M1 1l22 22" />
                        <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12" />
                        <path d="M14.12 9.88A3 3 0 0 1 9.88 14.12" />
                    </svg>
                </button>
            </div>
            <p class="mt-2 text-sm text-red-400">{{ $errors->first('password') }}</p>
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-200">Konfirmasi Password</label>
            <div class="relative">
                <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required autocomplete="new-password"
                       class="h-14 w-full rounded-2xl border border-slate-700 bg-slate-950/80 px-4 pr-12 text-white placeholder:text-slate-500 focus:border-emerald-500 focus:ring-emerald-500/20 focus:outline-none" />
                <button type="button" @click="showConfirm = !showConfirm" class="absolute inset-y-0 right-3 inline-flex items-center text-slate-400 transition hover:text-white">
                    <svg x-show="!showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    <svg x-show="showConfirm" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8 .9-1.76 2.18-3.29 3.79-4.51" />
                        <path d="M1 1l22 22" />
                        <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12" />
                        <path d="M14.12 9.88A3 3 0 0 1 9.88 14.12" />
                    </svg>
                </button>
            </div>
            <p class="mt-2 text-sm text-red-400">{{ $errors->first('password_confirmation') }}</p>
        </div>

        <button type="submit" :disabled="submitting"
                :class="submitting ? 'cursor-not-allowed opacity-80' : ''"
                class="flex w-full items-center justify-center rounded-2xl bg-emerald-500 px-6 py-4 text-sm font-semibold text-white shadow-lg shadow-emerald-500/20 transition duration-200 hover:bg-emerald-600 active:scale-[0.98]">
            <span x-text="submitting ? 'Mendaftar...' : 'Daftar'"></span>
        </button>

        <p class="text-center text-sm text-slate-400">
            Sudah punya akun? <a href="{{ route('login') }}" class="font-semibold text-white hover:text-emerald-300 transition">Masuk di sini</a>
        </p>
    </form>
</x-guest-layout>
