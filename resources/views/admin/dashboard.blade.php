<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Admin - LOKALKARYA</title>
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
                    <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-base">L</div>
                    <span class="font-extrabold text-base tracking-tight uppercase">Lokalkarya</span>
                </a>
                <button @click="sidebarOpen = true" class="w-9 h-9 flex items-center justify-center text-gray-500 hover:bg-gray-100 rounded-xl">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <header class="bg-white border-b border-gray-100 z-20">
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-4 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Halo Admin 👋</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Pantau performa platform LOKALKARYA.</p>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-6 pb-28 lg:pb-10 space-y-6">

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white px-6 py-5 rounded-[1.5rem] border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-bold text-gray-400 mb-2">Total Seller</h3>
                            <p class="text-4xl font-extrabold text-[#0f172a]">{{ $totalSeller }}</p>
                        </div>

                        <div class="bg-white px-6 py-5 rounded-[1.5rem] border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-bold text-gray-400 mb-2">Menunggu Verifikasi Akun</h3>
                            <p class="text-4xl font-extrabold text-[#0f172a]">{{ $pendingSeller }}</p>
                        </div>

                        <div class="bg-white px-6 py-5 rounded-[1.5rem] border border-gray-100 shadow-sm">
                            <h3 class="text-xs font-bold text-gray-400 mb-2">Menunggu Verifikasi Jasa / Produk</h3>
                            <p class="text-4xl font-extrabold text-[#0f172a]">{{ $pendingProduk }}</p>
                        </div>

                        <a href="{{ route('admin.kategori') }}"
                            class="bg-indigo-600 px-6 py-5 rounded-[1.5rem] border border-indigo-600 shadow-sm hover:bg-indigo-700 transition-colors group cursor-pointer block">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="text-xs font-bold text-indigo-200">Total Kategori</h3>
                                <svg class="w-4 h-4 text-indigo-300 group-hover:translate-x-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </div>
                            <p class="text-4xl font-extrabold text-white">{{ $totalKategori }}</p>
                            <p class="text-[11px] font-semibold text-indigo-200 mt-1">Kelola kategori →</p>
                        </a>
                    </div>

                    <div>
                        <h2 class="text-xl font-extrabold text-gray-900 mb-6">Aktivitas Terbaru</h2>

                        <div class="space-y-4">
                            @forelse($recentActivities as $activity)
                            <div
                                class="bg-white border border-gray-100 p-5 rounded-2xl flex flex-col sm:flex-row sm:justify-between sm:items-start gap-2 shadow-sm">
                                <div>
                                    <h4 class="font-extrabold text-gray-900 text-sm mb-1">{{ $activity['judul'] }}</h4>
                                    <p class="text-sm text-gray-500 font-medium">{{ $activity['deskripsi'] }}</p>
                                </div>
                                <span class="text-xs font-bold text-gray-400 whitespace-nowrap">{{ $activity['waktu'] ? $activity['waktu']->diffForHumans() : '-' }}</span>
                            </div>
                            @empty
                            <div class="bg-white border border-gray-100 p-8 rounded-2xl text-center text-gray-400 shadow-sm">
                                <p class="text-sm font-medium">Belum ada aktivitas terbaru.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>
</body>

</html>
