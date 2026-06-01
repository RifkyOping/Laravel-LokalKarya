<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard Seller - LOKALKARYA</title>
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
                <div class="max-w-6xl mx-auto px-4 sm:px-8 py-4 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Halo Seller 👋</h2>
                    <p class="text-gray-500 mt-0.5 text-xs sm:text-sm">Pantau performa toko dan produk Anda.</p>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-6xl mx-auto p-4 sm:p-6 md:p-10 pb-28 lg:pb-10">
                    <!-- Profile Card -->
                    <div class="bg-white p-5 sm:p-8 rounded-3xl border border-gray-100 shadow-sm relative mb-6 sm:mb-10">
                        <div class="flex items-center gap-4">
                            <img src="{{ Auth::user()->sellerProfile && Auth::user()->sellerProfile->foto ? asset('storage/' . Auth::user()->sellerProfile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Seller') . '&background=2563eb&color=fff&size=200' }}"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl shadow-lg shadow-blue-600/10 border-2 border-white object-cover shrink-0">

                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg sm:text-2xl font-extrabold text-gray-900 flex items-center gap-1.5 flex-wrap">
                                    {{ Auth::user()->name ?? 'Seller' }}
                                    @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->status_verifikasi == 'diterima')
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    @endif
                                </h3>
                                <p class="text-gray-500 text-xs sm:text-sm mt-0.5">{{ Auth::user()->sellerProfile->bidang_keahlian ?? 'Creative Designer' }}</p>
                                <p class="text-gray-700 text-xs sm:text-sm mt-2 line-clamp-2">
                                    {{ Auth::user()->sellerProfile->deskripsi ?? 'Membantu kebutuhan publikasi seminar, webinar, dan event kampus.' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <h2 class="text-lg sm:text-2xl font-extrabold text-gray-900">Jasa & Produk Aktif</h2>
                        <a href="{{ route('produk.seller') }}" class="text-xs font-bold text-blue-600 hover:text-blue-700">Kelola →</a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-3 sm:gap-5">
                        @forelse($produks as $produk)
                        <a href="{{ route('produk.detail', $produk->id) }}"
                            class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col group hover:border-blue-200 hover:shadow-md transition-all">
                            <div class="h-36 sm:h-44 overflow-hidden relative">
                                <img src="{{ produk_image_url($produk->gambar_produk, 'https://placehold.co/600x400/e2e8f0/64748b?text=No+Image') }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <span class="absolute top-2 left-2 text-[10px] font-bold uppercase bg-white/90 text-blue-600 px-2 py-0.5 rounded-lg">
                                    {{ ucwords(str_replace('-', ' ', $produk->kategori)) }}
                                </span>
                            </div>
                            <div class="p-3 sm:p-5 flex flex-col flex-1">
                                <h3 class="font-bold text-gray-900 text-xs sm:text-sm leading-tight mb-2 flex-grow line-clamp-2">
                                    {{ $produk->nama_produk }}
                                </h3>
                                <div class="pt-2 border-t border-gray-50">
                                    <p class="text-gray-400 text-[10px] sm:text-xs">Harga mulai dari</p>
                                    <p class="font-extrabold text-sm sm:text-base text-indigo-600">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="col-span-full py-12 text-center text-gray-400 bg-white rounded-[2rem] border border-gray-100 shadow-sm">
                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                            <p class="font-semibold text-gray-500 text-sm">Belum ada jasa atau produk aktif</p>
                            <p class="text-xs text-gray-400 mt-1">Produk yang telah disetujui oleh admin akan muncul di sini.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
