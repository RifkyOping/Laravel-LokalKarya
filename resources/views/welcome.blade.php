<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOKALKARYA - Katalog Jasa Mahasiswa</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.7s ease-out forwards;
        }

        .filter-scroll::-webkit-scrollbar {
            display: none;
        }

        .filter-scroll {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-gray-900">

    <!-- Header -->
    <header class="bg-white border-b border-gray-100 sticky top-0 z-40" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 sm:h-20">
                <a href="{{ url('/') }}" class="flex items-center gap-2">
                    <x-logo />
                </a>

                <nav class="hidden md:flex space-x-8">
                    <a href="{{ url('/') }}"
                        class="text-gray-900 font-medium text-sm hover:text-blue-600 transition-colors">Beranda</a>
                    <a href="#katalog"
                        class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">Katalog</a>
                    <a href="#footer"
                        class="text-gray-500 hover:text-gray-900 font-medium text-sm transition-colors">Kontak</a>
                </nav>

                <div class="hidden md:flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-sm font-medium text-gray-700 hover:text-blue-600">Dashboard</a>
                        @endauth
                    @endif
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-all hover:shadow-lg active:scale-95">
                        Mulai Jual Karya
                    </a>
                </div>

                <!-- Mobile: CTA + Menu -->
                <div class="flex md:hidden items-center gap-2">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-2 rounded-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}"
                            class="text-xs font-bold text-white bg-blue-600 px-3 py-2 rounded-lg">Jual Karya</a>
                    @endauth
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" style="display:none;" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Dropdown Menu -->
        <div x-show="mobileMenuOpen" x-transition class="md:hidden bg-white border-t border-gray-100 shadow-lg"
            style="display:none;">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ url('/') }}"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-800 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">🏠
                    Beranda</a>
                <a href="#katalog" @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">🛍️
                    Katalog</a>
                <a href="#footer" @click="mobileMenuOpen = false"
                    class="flex items-center gap-3 px-3 py-2.5 text-sm font-semibold text-gray-500 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">📬
                    Kontak</a>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="py-8 sm:py-14 text-center max-w-4xl mx-auto px-4 animate-fade-in-up">
        <div
            class="inline-block bg-blue-50 text-blue-600 px-3 py-1 rounded-full text-[11px] sm:text-xs font-semibold tracking-wide mb-4">
            ✨ Platform Jasa Kreatif Mahasiswa Universitas Sulawesi Barat
        </div>

        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-4 leading-tight">
            Dari Mahasiswa <br class="sm:hidden"> untuk <span class="text-blue-600">Sulawesi Barat</span>
        </h1>

        <p class="text-sm sm:text-base text-gray-500 mb-6 max-w-xl mx-auto leading-relaxed">
            Temukan jasa desain, UI/UX, video editing, fotografi, dan karya kreatif dari mahasiswa berbakat Sulawesi
            Barat.
        </p>

        <!-- Search Bar - Mobile optimized -->
        <form action="{{ route('home') }}" method="GET" class="max-w-2xl mx-auto mb-6">
            <div
                class="flex items-center bg-white rounded-2xl border border-gray-200 shadow-md overflow-hidden focus-within:border-blue-500 focus-within:ring-2 focus-within:ring-blue-100 transition-all">
                <div class="relative flex-1 flex items-center">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 absolute left-3 sm:left-4" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Cari jasa atau produk..."
                        class="w-full bg-transparent border-none focus:ring-0 text-sm text-gray-900 pl-9 sm:pl-12 pr-3 py-3 sm:py-3.5 outline-none">
                </div>
                <select name="filter_type"
                    class="hidden sm:block bg-transparent border-none focus:ring-0 text-xs text-gray-600 font-semibold pr-6 py-3 cursor-pointer outline-none border-l border-gray-100 pl-3">
                    <option value="semua" {{ request('filter_type') == 'semua' ? 'selected' : '' }}>Semua</option>
                    <option value="judul" {{ request('filter_type') == 'judul' ? 'selected' : '' }}>Judul</option>
                    <option value="kategori" {{ request('filter_type') == 'kategori' ? 'selected' : '' }}>Kategori
                    </option>
                    <option value="seller" {{ request('filter_type') == 'seller' ? 'selected' : '' }}>Seller</option>
                </select>
                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 sm:px-6 py-3 sm:py-3.5 text-sm font-bold transition-all active:scale-95 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <span class="hidden sm:inline">Cari</span>
                </button>
            </div>
        </form>

        <!-- Category Pills - Horizontal scroll on mobile -->
        <div class="flex gap-2 overflow-x-auto filter-scroll pb-1 justify-start sm:justify-center px-0">
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => null])) }}"
                class="shrink-0 {{ !request('kategori') ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">Semua</a>
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => 'Social-Media'])) }}"
                class="shrink-0 {{ request('kategori') == 'Social-Media' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">Social
                Media</a>
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => 'UI-Design'])) }}"
                class="shrink-0 {{ request('kategori') == 'UI-Design' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">UI
                Design</a>
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => 'Desain-Grafis'])) }}"
                class="shrink-0 {{ request('kategori') == 'Desain-Grafis' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">Desain
                Grafis</a>
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => 'Video-Editing'])) }}"
                class="shrink-0 {{ request('kategori') == 'Video-Editing' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">Video
                Editing</a>
            <a href="{{ route('home', array_merge(request()->query(), ['kategori' => 'Fotografi'])) }}"
                class="shrink-0 {{ request('kategori') == 'Fotografi' ? 'bg-blue-600 text-white shadow-md shadow-blue-200' : 'bg-white text-gray-600 border border-gray-200' }} px-4 py-2 rounded-full text-xs font-semibold transition-all active:scale-95">Fotografi</a>
        </div>
    </section>

    <!-- Catalog Section -->
    <section id="katalog" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl sm:text-2xl font-extrabold text-gray-900">Jasa & Produk</h2>
            @if(request('search') || request('kategori'))
                <a href="{{ route('home') }}"
                    class="text-xs font-semibold text-blue-600 hover:text-blue-700 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    Reset
                </a>
            @endif
        </div>

        <!-- 2-col on mobile, 2 on sm, 3 on md, 4 on lg -->
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-5 lg:gap-6">
            @forelse ($produks as $produk)
                <a href="{{ route('produk.detail', $produk->id) }}"
                    class="bg-white rounded-2xl border border-gray-100 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col">
                    <div class="relative overflow-hidden">
                        <img src="{{ produk_image_url($produk->gambar_produk, 'https://placehold.co/400x300/e2e8f0/64748b?text=' . urlencode($produk->kategori)) }}"
                            alt="{{ $produk->nama_produk }}"
                            class="w-full h-32 sm:h-44 object-cover group-hover:scale-105 transition-transform duration-500">
                        <span
                            class="absolute top-2 left-2 text-[9px] sm:text-[10px] font-bold uppercase tracking-wider text-blue-600 bg-white/90 backdrop-blur-sm px-1.5 sm:px-2 py-0.5 sm:py-1 rounded-md">{{ $produk->kategori }}</span>
                    </div>
                    <div class="p-3 sm:p-4 flex flex-col flex-grow">
                        <h3 class="font-bold text-gray-900 text-xs sm:text-sm leading-tight mb-1 flex-grow line-clamp-2">
                            {{ $produk->nama_produk }}</h3>
                        <div class="flex items-center gap-1 mb-2 sm:mb-3">
                            <span class="text-[10px] sm:text-xs text-gray-500 truncate">{{ $produk->user->name }}</span>
                            @if($produk->user->sellerProfile && $produk->user->sellerProfile->status_verifikasi == 'diterima')
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-blue-500 shrink-0" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </div>
                        <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                            <div>
                                <span class="text-[9px] sm:text-xs text-gray-400 block">Mulai dari</span>
                                <span
                                    class="font-extrabold text-xs sm:text-sm text-gray-900">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                            <span
                                class="text-[9px] sm:text-xs font-bold text-blue-600 bg-blue-50 px-2 py-1 rounded-lg">Lihat
                                →</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-16">
                    <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-gray-900 mb-1">Tidak ada produk</h3>
                    <p class="text-xs text-gray-500">Belum ada jasa yang sesuai pencarian Anda.</p>
                    <a href="{{ route('home') }}"
                        class="inline-block mt-4 text-xs font-bold text-blue-600 hover:text-blue-700">Lihat semua →</a>
                </div>
            @endforelse
        </div>
    </section>

    <!-- CTA Section -->
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-12">
        <div
            class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl p-8 sm:p-12 md:p-16 text-center text-white shadow-2xl shadow-blue-600/20">
            <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold mb-3">Dapatkan Klien Pertamamu</h2>
            <p class="text-blue-100 max-w-lg mx-auto mb-6 text-sm leading-relaxed">
                Buat profil, upload karyamu, dan mulai mendapatkan penghasilan dari keahlian kreatifmu.
            </p>
            <a href="{{ route('login') }}"
                class="inline-block bg-white text-blue-600 hover:bg-blue-50 px-8 py-3 rounded-2xl font-bold text-sm transition-all hover:shadow-lg active:scale-95">
                Daftar Gratis Sekarang →
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="footer" class="bg-white border-t border-gray-100 pt-10 pb-8 mt-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-8 mb-8">
                <div class="col-span-2 sm:col-span-1">
                    <div class="flex items-center gap-2 mb-3">
                        <div
                            class="w-7 h-7 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-base">
                            L</div>
                        <span class="font-extrabold text-base tracking-tight">LOKALKARYA</span>
                    </div>
                    <p class="text-gray-500 text-xs leading-relaxed">Platform pemasaran jasa kreatif mahasiswa
                        Universitas Sulawesi Barat.</p>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Navigasi</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li><a href="{{ url('/') }}" class="hover:text-blue-600 transition-colors">Beranda</a></li>
                        <li><a href="#katalog" class="hover:text-blue-600 transition-colors">Katalog</a></li>
                        <li><a href="{{ route('login') }}" class="hover:text-blue-600 transition-colors">Jual Karya</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 mb-3 text-sm">Kontak</h4>
                    <ul class="space-y-2 text-xs text-gray-500">
                        <li>hello@lokalkarya.id</li>
                        <li>@lokalkarya.id</li>
                        <li>Indonesia 🇮🇩</li>
                    </ul>
                </div>
            </div>
            <div class="text-center text-xs text-gray-400 border-t border-gray-100 pt-6">
                © 2026 LOKALKARYA. All rights reserved.
            </div>
        </div>
    </footer>

</body>

</html>