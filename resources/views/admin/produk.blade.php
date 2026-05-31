<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Produk - LOKALKARYA</title>
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
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Verifikasi Jasa / Produk</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Kelola dan verifikasi layanan yang diajukan kreator.</p>
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @forelse($produks as $produk)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 sm:p-5">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image' }}"
                                alt="Thumbnail"
                                class="w-16 h-16 sm:w-20 sm:h-20 rounded-2xl object-cover border border-gray-100 shadow-sm shrink-0">

                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <div class="min-w-0">
                                        <h4 class="font-extrabold text-gray-900 text-sm leading-snug line-clamp-2">{{ $produk->nama_produk }}</h4>
                                        <p class="text-xs text-gray-500 mt-0.5">oleh <span class="font-semibold text-gray-700">{{ $produk->user->name ?? '-' }}</span></p>
                                    </div>
                                    @if($produk->status_verifikasi === 'diterima')
                                        <span class="shrink-0 text-[10px] font-bold text-green-700 bg-green-50 px-2 py-1 rounded-full">✓ Disetujui</span>
                                    @elseif($produk->status_verifikasi === 'ditolak')
                                        <span class="shrink-0 text-[10px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded-full">✕ Ditolak</span>
                                    @else
                                        <span class="shrink-0 text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-full">⏳ Tunggu</span>
                                    @endif
                                </div>

                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-lg">{{ ucwords(str_replace('-', ' ', $produk->kategori)) }}</span>
                                </div>

                                <div class="flex flex-wrap gap-2">
                                    @if($produk->status_verifikasi === 'menunggu')
                                        <form action="{{ route('admin.produk.setujui', $produk->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all active:scale-95">Setujui</button>
                                        </form>
                                        <form action="{{ route('admin.produk.tolak', $produk->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-gray-700 bg-white border border-gray-200 hover:border-red-400 hover:text-red-600 transition-all active:scale-95">Tolak</button>
                                        </form>
                                    @elseif($produk->status_verifikasi === 'ditolak')
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-all active:scale-95">Hapus Permanen</button>
                                        </form>
                                    @elseif($produk->status_verifikasi === 'diterima')
                                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus produk yang sudah aktif ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-all active:scale-95">Hapus</button>
                                        </form>
                                    @endif
                                </div>

                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="col-span-1 sm:col-span-2 bg-white border border-gray-100 p-10 rounded-2xl text-center shadow-sm">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="h-7 w-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-500 text-sm">Tidak ada jasa atau produk</p>
                        <p class="text-xs text-gray-400 mt-1">Produk baru dari seller akan muncul di sini.</p>
                    </div>
                    @endforelse
                    </div>

                </div>
            </main>

        </div>
    </div>
</body>

</html>