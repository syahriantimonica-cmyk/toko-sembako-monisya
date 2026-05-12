<x-guest-layout>
    <div class="mb-8 text-center">
        <h1 class="text-4xl font-bold text-white">
             Monisya Mart
        </h1>

        <p class="mt-2 text-sm text-blue-100">
            Gunakan dashboard kasir modern untuk mengelola transaksi toko.
        </p>
    </div>

    <!-- SESSION STATUS -->
    <x-auth-session-status
        class="mb-4 rounded-2xl border p-4 text-sm text-blue-100"
        style="background:#60a5fa20; border-color:#93c5fd;"
        :status="session('status')"
    />

    <!-- VALIDATION ERROR -->
    <x-auth-validation-errors
        class="mb-4 rounded-2xl border p-4 text-sm text-red-100"
        style="background:#ef444420; border-color:#f87171;"
        :errors="$errors"
    />

    <!-- FORM -->
    <form
        x-data="{ showPassword: false, submitting: false }"
        @submit="submitting = true"
        method="POST"
        action="{{ route('login') }}"
        class="space-y-6 rounded-3xl border p-8 shadow-2xl"
        style="background:#1e3a8a55; border-color:#93c5fd;"
    >
        @csrf

        <!-- EMAIL -->
        <div class="space-y-2">
            <label
                for="email"
                class="block text-sm font-medium text-blue-100"
            >
                Email
            </label>

            <input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"

                class="h-14 w-full rounded-2xl border px-4 text-white placeholder:text-blue-200 focus:outline-none"

                style="
                    background:#bfdbfe20;
                    border-color:#93c5fd;
                "
            />

            <p class="mt-2 text-sm text-red-300">
                {{ $errors->first('email') }}
            </p>
        </div>

        <!-- PASSWORD -->
        <div class="space-y-2">

            <label
                for="password"
                class="block text-sm font-medium text-blue-100"
            >
                Password
            </label>

            <div class="relative">

                <input
                    id="password"
                    name="password"
                    :type="showPassword ? 'text' : 'password'"
                    required
                    autocomplete="current-password"

                    class="h-14 w-full rounded-2xl border px-4 pr-12 text-white placeholder:text-blue-200 focus:outline-none"

                    style="
                        background:#bfdbfe20;
                        border-color:#93c5fd;
                    "
                />

                <!-- SHOW PASSWORD -->
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute inset-y-0 right-3 inline-flex items-center text-blue-200 transition hover:text-white"
                >

                    <!-- EYE -->
                    <svg
                        x-show="!showPassword"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>

                    <!-- EYE OFF -->
                    <svg
                        x-show="showPassword"
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    >
                        <path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8 .9-1.76 2.18-3.29 3.79-4.51"/>
                        <path d="M1 1l22 22"/>
                        <path d="M9.88 9.88A3 3 0 0 0 14.12 14.12"/>
                        <path d="M14.12 9.88A3 3 0 0 1 9.88 14.12"/>
                    </svg>

                </button>
            </div>

            <p class="mt-2 text-sm text-red-300">
                {{ $errors->first('password') }}
            </p>
        </div>

        <!-- REMEMBER -->
        <div class="flex items-center justify-between gap-3">

            <label
                for="remember_me"
                class="inline-flex items-center gap-2 text-sm text-blue-100"
            >

                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"

                    class="h-4 w-4 rounded"

                    style="
                        background:#dbeafe;
                        border-color:#93c5fd;
                    "
                />

                <span>Remember me</span>
            </label>

            @if (Route::has('password.request'))

                <a
                    href="{{ route('password.request') }}"
                    class="text-sm text-blue-200 hover:text-white transition"
                >
                    Lupa password?
                </a>

            @endif
        </div>

        <!-- BUTTON -->
        <button
            type="submit"
            :disabled="submitting"
            :class="submitting ? 'cursor-not-allowed opacity-80' : ''"

            class="flex w-full items-center justify-center rounded-2xl px-6 py-4 text-sm font-semibold text-white shadow-lg transition duration-200 hover:scale-[1.01] active:scale-[0.98]"

            style="
                background:#60a5fa;
            "
        >

            <span x-text="submitting ? 'Masuk...' : 'Masuk'"></span>

        </button>

    </form>

    <!-- REGISTER -->
    <p class="mt-8 text-center text-sm text-blue-100">

        Belum punya akun?

        <a
            href="{{ route('register') }}"
            class="font-semibold text-white hover:text-blue-200 transition"
        >
            Daftar sekarang
        </a>

    </p>
</x-guest-layout>