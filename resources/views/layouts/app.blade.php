<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'LOKALKARYA') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gray-50 font-sans antialiased text-gray-900">
        <div class="flex min-h-screen" x-data="{ sidebarOpen: false }">
            @include('layouts.navigation')

            <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
                <!-- Mobile top bar -->
                <div class="lg:hidden bg-white border-b border-gray-100 flex items-center justify-between px-4 py-3 sticky top-0 z-30 shadow-sm">
                    <a href="{{ url('/') }}" class="flex items-center gap-2">
                        <x-logo />
                    </a>
                </div>

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white border-b border-gray-100 z-20">
                        <div class="max-w-6xl mx-auto px-4 sm:px-8 py-4 sm:py-5">
                            <div class="text-xl font-extrabold text-gray-900 tracking-tight">
                                {{ $header }}
                            </div>
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto">
                    <!-- pb-24 for bottom nav on mobile -->
                    <div class="max-w-6xl mx-auto p-4 sm:p-6 md:p-10 lg:p-12 pb-28 lg:pb-12">
                        {{ $slot }}
                    </div>
                </main>
            </div>
        </div>
    </body>
</html>
