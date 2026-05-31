<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $produk->nama_produk }} - Katalog Jasa LOKALKARYA</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-gray-900 bg-gray-50">

    <header class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-2">
                    <div
                        class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        L</div>
                    <span class="font-extrabold text-xl tracking-tight">LOKALKARYA</span>
                </div>

                <nav class="flex space-x-8">
                    <a href="{{ url('/') }}"
                        class="inline-flex items-center gap-2 text-gray-900 font-medium text-sm transition-colors hover:text-blue-600">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                        </svg>

                        Kembali
                    </a>
                </nav>

            </div>
        </div>
    </header>

    <div class="py-8 min-h-screen">
        <div class="max-w-[1200px] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <div class="lg:col-span-2 space-y-8">

                    <div class="space-y-4">
                        <div
                            class="w-full h-[200px] sm:h-[360px] md:h-[460px] lg:h-[520px] rounded-[1.25rem] sm:rounded-[2rem] overflow-hidden border border-gray-100 shadow-sm bg-white">
                            <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80' }}"
                                alt="{{ $produk->nama_produk }}" class="w-full h-full object-cover">
                        </div>
                    </div>

                    <div class="p-5 sm:p-8 md:p-10 bg-white shadow-sm border border-gray-100 rounded-[1.5rem] sm:rounded-[2rem]">
                        <span
                            class="inline-flex items-center justify-center px-3 py-1 sm:px-4 sm:py-1.5 bg-indigo-50 text-indigo-600 font-bold text-xs rounded-full mb-3 sm:mb-4">
                            {{ $produk->kategori }}
                        </span>

                        <h1 class="text-xl sm:text-3xl md:text-4xl font-extrabold text-gray-900 leading-tight mb-3 sm:mb-4">
                            {{ $produk->nama_produk }}
                        </h1>

                        <div class="mb-5 sm:mb-8 mt-3 sm:mt-6">
                            <p class="text-xs sm:text-sm text-gray-500 font-bold mb-1">Harga mulai dari</p>
                            <h2 class="text-2xl sm:text-4xl md:text-5xl font-extrabold text-[#4F46E5]">Rp{{ number_format($produk->harga, 0, ',', '.') }}</h2>
                        </div>

                        <div>
                            <h3 class="text-base sm:text-lg font-extrabold text-gray-900 mb-3 sm:mb-4">Deskripsi</h3>
                            <div class="prose prose-sm text-gray-600 font-medium space-y-3 sm:space-y-4 whitespace-pre-line text-sm">
                                {{ $produk->deskripsi }}
                            </div>
                        </div>
                    </div>

                    @php
                        $portfolio = $produk->user->sellerProfile->link_portofolio ?? [];
                    @endphp

                    @if(!empty($portfolio))
                    <div class="pt-2 sm:pt-4">
                        <span class="text-[#4F46E5] font-bold text-xs sm:text-sm uppercase tracking-wider">Portfolio</span>
                        <h3 class="text-lg sm:text-2xl font-extrabold text-gray-900 mt-1 mb-4 sm:mb-6">Karya Seller</h3>

                        <div class="flex flex-col gap-3">
                            @foreach($portfolio as $item)
                            <a href="{{ $item['link'] ?? '#' }}" target="_blank" rel="noopener noreferrer"
                                class="flex items-center gap-4 bg-white border border-gray-100 rounded-2xl p-4 shadow-sm hover:shadow-md hover:border-indigo-200 transition-all group">
                                <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center shrink-0 group-hover:bg-indigo-100 transition-colors">
                                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-gray-900 truncate">{{ $item['judul'] ?? 'Link Karya' }}</p>
                                    <p class="text-xs text-indigo-500 font-medium truncate mt-0.5">{{ $item['link'] ?? '' }}</p>
                                </div>
                                <svg class="w-4 h-4 text-gray-300 shrink-0 group-hover:text-indigo-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div>

                <div class="lg:col-span-1">

                    <div class="p-5 sm:p-6 bg-white shadow-sm border border-gray-100 rounded-[1.5rem] sm:rounded-[2rem] lg:sticky lg:top-8">

                        <div class="flex items-center gap-4 mb-6">
                            <img src="{{ $produk->user->sellerProfile && $produk->user->sellerProfile->foto ? asset('storage/' . $produk->user->sellerProfile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($produk->user->name) . '&background=1f2937&color=fff' }}"
                                alt="Avatar"
                                class="w-14 h-14 rounded-full object-cover border border-gray-100 shadow-sm">
                            <div>
                                <div class="flex items-center gap-1.5">
                                    <h3 class="font-extrabold text-gray-900 text-base">{{ $produk->user->name }}</h3>
                                    @if($produk->user->sellerProfile && $produk->user->sellerProfile->status_verifikasi == 'diterima')
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-500 font-medium">{{ $produk->user->sellerProfile->bidang_keahlian ?? 'Seller' }}</p>
                            </div>
                        </div>

                        @if($produk->user->sellerProfile && $produk->user->sellerProfile->deskripsi)
                        <div
                            class="bg-indigo-50/50 text-indigo-700 p-4 rounded-xl text-sm font-medium mb-6 leading-relaxed">
                            {{ $produk->user->sellerProfile->deskripsi }}
                        </div>
                        @endif

                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="px-3 py-1.5 bg-gray-50 border border-gray-100 text-gray-600 rounded-full text-xs font-bold">{{ $produk->kategori }}</span>
                        </div>

                        <div class="space-y-3">
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $produk->user->sellerProfile->nomor_whatsapp ?? '') }}?text=Halo%20{{ urlencode($produk->user->name) }},%20saya%20tertarik%20dengan%20jasa/produk%20{{ urlencode($produk->nama_produk) }}%20di%20LOKALKARYA." target="_blank"
                                class="w-full flex items-center justify-center gap-2 bg-white hover:bg-green-600 hover:text-white text-black px-6 py-3.5 rounded-xl font-bold text-sm shadow-md shadow-gray-200/50 transition-all hover:-translate-y-0.5 active:scale-95 border border-gray-100">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232" />
                                </svg>
                                Diskusikan via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>
