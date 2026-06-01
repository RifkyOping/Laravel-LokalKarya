<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa & Produk Saya - LOKALKARYA</title>
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
                <div class="max-w-6xl mx-auto px-4 sm:px-8 py-4 sm:py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Jasa & Produk Saya</h2>
                        <p class="text-gray-500 text-xs mt-0.5">Kelola semua jasa dan produk kreatif Anda.</p>
                    </div>
                    <a href="{{ route('seller.create') }}"
                        class="hidden sm:flex items-center gap-1.5 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Tambah Jasa
                    </a>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-5xl mx-auto p-4 sm:p-6 md:p-10 pb-28 lg:pb-10">

                    @if(session('success'))
                    <div class="mb-5 p-3.5 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 text-green-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs sm:text-sm font-bold">{{ session('success') }}</span>
                    </div>
                    @endif

                    @php
                        $sections = [
                            ['title' => 'Jasa Disetujui', 'subtitle' => 'Aktif & ditampilkan di katalog', 'dot' => 'bg-green-500', 'badge_bg' => 'bg-green-50', 'badge_text' => 'text-green-700', 'label' => 'Aktif', 'items' => $produksDiterima ?? []],
                            ['title' => 'Menunggu Verifikasi', 'subtitle' => 'Sedang ditinjau oleh admin', 'dot' => 'bg-amber-400', 'badge_bg' => 'bg-amber-50', 'badge_text' => 'text-amber-700', 'label' => 'Menunggu', 'items' => $produksMenunggu ?? []],
                            ['title' => 'Jasa Ditolak', 'subtitle' => 'Perlu diperbaiki & diajukan ulang', 'dot' => 'bg-red-500', 'badge_bg' => 'bg-red-50', 'badge_text' => 'text-red-700', 'label' => 'Ditolak', 'items' => $produksDitolak ?? []],
                        ];
                    @endphp

                    @foreach($sections as $section)
                    <div class="mb-8">
                        <!-- Section Header -->
                        <div class="flex items-center gap-2.5 mb-3">
                            <span class="w-2 h-2 rounded-full {{ $section['dot'] }}"></span>
                            <div>
                                <h3 class="font-extrabold text-gray-800 text-sm sm:text-base tracking-tight inline">{{ $section['title'] }}</h3>
                                <span class="ml-2 text-xs font-bold text-gray-400">({{ count($section['items']) }})</span>
                            </div>
                        </div>

                        @if(count($section['items']) > 0)
                            {{-- MOBILE: Card View --}}
                            <div class="space-y-3 sm:hidden">
                                @foreach($section['items'] as $produk)
                                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex gap-3">
                                    <img src="{{ produk_image_url($produk->gambar_produk, 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image') }}"
                                        class="w-16 h-16 rounded-xl object-cover border border-gray-100 shrink-0">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between gap-2 mb-1">
                                            <h4 class="font-bold text-gray-900 text-sm leading-snug line-clamp-2 flex-1">{{ $produk->nama_produk }}</h4>
                                            <span class="shrink-0 text-[9px] font-bold px-1.5 py-0.5 rounded-lg {{ $section['badge_bg'] }} {{ $section['badge_text'] }}">{{ $section['label'] }}</span>
                                        </div>
                                        <span class="inline-block text-[10px] font-bold text-blue-600 bg-blue-50 px-2 py-0.5 rounded-md mb-1.5">{{ ucwords(str_replace('-', ' ', $produk->kategori)) }}</span>
                                        <p class="font-extrabold text-indigo-600 text-sm">Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                        <div class="flex gap-2 mt-2.5">
                                            <a href="{{ route('seller.edit', $produk->id) }}"
                                                title="Edit"
                                                class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200 hover:bg-blue-50 hover:text-blue-600 hover:border-blue-200 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </a>
                                            <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus produk ini?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    title="Hapus"
                                                    class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            {{-- DESKTOP: Table View --}}
                            <div class="hidden sm:block bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse min-w-[640px]">
                                        <thead>
                                            <tr class="border-b border-gray-100 bg-gray-50/50">
                                                <th class="px-5 py-3 text-gray-400 font-bold text-[11px] uppercase tracking-wider">Produk</th>
                                                <th class="px-5 py-3 text-gray-400 font-bold text-[11px] uppercase tracking-wider">Kategori</th>
                                                <th class="px-5 py-3 text-gray-400 font-bold text-[11px] uppercase tracking-wider">Harga</th>
                                                <th class="px-5 py-3 text-gray-400 font-bold text-[11px] uppercase tracking-wider">Status</th>
                                                <th class="px-5 py-3 text-gray-400 font-bold text-[11px] uppercase tracking-wider text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-50">
                                            @foreach($section['items'] as $produk)
                                            <tr class="hover:bg-gray-50/50 transition-colors">
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center gap-3">
                                                        <img src="{{ produk_image_url($produk->gambar_produk, 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image') }}"
                                                            class="w-11 h-11 rounded-xl object-cover border border-gray-100 shrink-0">
                                                        <span class="font-bold text-gray-900 text-sm line-clamp-2 max-w-[200px]">{{ $produk->nama_produk }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="px-2.5 py-1 bg-blue-50 text-blue-600 font-bold text-[11px] rounded-full">{{ ucwords(str_replace('-', ' ', $produk->kategori)) }}</span>
                                                </td>
                                                <td class="px-5 py-4 font-extrabold text-indigo-600 text-sm">
                                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                                </td>
                                                <td class="px-5 py-4">
                                                    <span class="px-2.5 py-1 font-bold text-[11px] rounded-full {{ $section['badge_bg'] }} {{ $section['badge_text'] }}">{{ $section['label'] }}</span>
                                                </td>
                                                <td class="px-5 py-4">
                                                    <div class="flex items-center justify-center gap-1.5">
                                                        <a href="{{ route('seller.edit', $produk->id) }}"
                                                            title="Edit"
                                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                                        </a>
                                                        <form action="{{ route('produk.destroy', $produk->id) }}" method="POST"
                                                            onsubmit="return confirm('Yakin hapus produk ini?')">
                                                            @csrf @method('DELETE')
                                                            <button type="submit"
                                                                title="Hapus"
                                                                class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors">
                                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @else
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm py-8 text-center">
                                <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                                    <svg class="h-5 w-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-400 font-medium">Belum ada jasa di kategori ini</p>
                            </div>
                        @endif
                    </div>
                    @endforeach

                </div>
            </main>
        </div>
    </div>
</body>

</html>
