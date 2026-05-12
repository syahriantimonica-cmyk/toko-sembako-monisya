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
        
        <style>
            [x-cloak] { display: none !important; }
            body.mobile-sidebar-open .mobile-sticky-checkout {
                transform: translateY(100%);
                opacity: 0;
                pointer-events: none;
            }
        </style>
    </head>
    <body class="font-sans antialiased bg-slate-50 text-slate-900 overflow-x-hidden">
        <div class="flex min-h-screen bg-slate-100 overflow-x-hidden w-full">
            @include('layouts.navigation')

            <main class="w-full lg:ml-72 overflow-x-hidden pt-14 lg:pt-0">
                <div class="w-full px-4 sm:px-6 lg:px-8 py-6">
                    @isset($header)
                        <div class="mb-6">
                            {{ $header }}
                        </div>
                    @endisset

                    <div class="space-y-6">
                        @hasSection('content')
                            @yield('content')
                        @else
                            {{ $slot }}
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
