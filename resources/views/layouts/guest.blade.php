<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-white">

    <!-- BACKGROUND -->
    <div
        class="relative min-h-screen overflow-hidden"
        style="
            background:
            linear-gradient(
                135deg,
                #dbeafe 0%,
                #bfdbfe 20%,
                #93c5fd 40%,
                #60a5fa 60%,
                #3b82f6 80%,
                #2563eb 100%
            );
        "
    >

        <!-- BLUR EFFECT -->
        <div
            class="pointer-events-none absolute -top-24 left-1/2 h-96 w-96 -translate-x-1/2 rounded-full blur-3xl"
            style="background:rgba(255,255,255,0.25);"
        ></div>

        <div
            class="pointer-events-none absolute bottom-0 right-0 h-96 w-96 rounded-full blur-3xl"
            style="background:rgba(191,219,254,0.35);"
        ></div>

        <!-- CONTENT -->
        <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-10">

            <div class="w-full max-w-md">

                <!-- LOGO -->
                <div class="mb-8 text-center">

                    <a
                        href="/"
                        class="inline-flex items-center justify-center gap-3 text-white"
                    >

                        <!-- ICON -->
                        <div
                            class="flex h-14 w-14 items-center justify-center rounded-2xl shadow-2xl"
                            style="
                                background:rgba(255,255,255,0.25);
                                backdrop-filter:blur(12px);
                            "
                        >

                            <x-application-logo class="h-8 w-8 text-white" />

                        </div>

                        <!-- TITLE -->
                        <div class="text-left">

                            <span class="block text-3xl font-bold tracking-tight">
                                Toko Sembako
                            </span>

                            <span class="text-blue-100 text-sm">
                                Monisya Mart
                            </span>

                        </div>

                    </a>

                    <p class="mt-4 text-sm text-blue-100">
                    Masuk untuk mulai mengelola toko dengan sistem kasir modern.
                    </p>

                </div>

                <!-- CARD FORM -->
                <div
                    class="rounded-[32px] border p-8 md:p-10 shadow-2xl"
                    style="
                        background:rgba(255,255,255,0.15);
                        backdrop-filter:blur(18px);
                        border-color:rgba(255,255,255,0.25);
                    "
                >

                    {{ $slot }}

                </div>

            </div>

        </div>

    </div>

</body>
</html>