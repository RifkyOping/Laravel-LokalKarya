<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi Seller - LOKALKARYA</title>
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

            <header class="bg-white border-b border-gray-100 z-20">
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-4 sm:py-5">
                    <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Verifikasi Seller</h2>
                    <p class="text-gray-500 text-xs mt-0.5">Kelola dan verifikasi pendaftaran akun seller baru.</p>
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
                    @forelse($sellers as $seller)
                    <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-4 sm:p-5">
                        <!-- Mobile Layout -->
                        <div class="flex items-start gap-4">
                            <img src="{{ $seller->foto ? asset('storage/' . $seller->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($seller->user->name ?? 'Seller') . '&background=4F46E5&color=fff' }}"
                                alt="Profile"
                                class="w-14 h-14 rounded-2xl object-cover border border-gray-100 shadow-sm shrink-0">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-2 mb-1">
                                    <div>
                                        <h4 class="font-extrabold text-gray-900 text-sm">{{ $seller->user->name ?? '-' }}</h4>
                                        <p class="text-xs text-gray-500 truncate">{{ $seller->user->email ?? '-' }}</p>
                                    </div>
                                    @if($seller->status_verifikasi === 'diterima')
                                        <span class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold text-green-700 bg-green-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>Disetujui
                                        </span>
                                    @elseif($seller->status_verifikasi === 'ditolak')
                                        <span class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold text-red-700 bg-red-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>Ditolak
                                        </span>
                                    @else
                                        <span class="shrink-0 inline-flex items-center gap-1 text-[10px] font-bold text-amber-700 bg-amber-50 px-2 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>Menunggu
                                        </span>
                                    @endif
                                </div>
                                @if($seller->nomor_whatsapp)
                                <p class="text-xs text-gray-500 mb-3">
                                    {{ $seller->nomor_whatsapp }}</p>
                                @endif
                                <div class="flex flex-wrap items-center gap-2">
                                    @if($seller->status_verifikasi === 'menunggu')
                                        <form action="{{ route('admin.seller.setujui', $seller->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 transition-all active:scale-95">✓ Setujui</button>
                                        </form>
                                    @elseif($seller->status_verifikasi === 'diterima')
                                        <form action="{{ route('admin.seller.tolak', $seller->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-all active:scale-95">Batalkan</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.seller.setujui', $seller->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold text-green-700 bg-green-50 hover:bg-green-100 transition-all active:scale-95">Setujui Kembali</button>
                                        </form>
                                    @endif

                                    {{-- Tombol Hapus Akun Seller --}}
                                    <form action="{{ route('admin.seller.destroy', $seller->id) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.seller.destroy', $seller->id) }}', 'Hapus Akun Seller?', 'Akun {{ addslashes($seller->user->name ?? '') }} beserta semua produk dan datanya akan dihapus permanen.')"
                                            title="Hapus Akun Seller"
                                            class="w-8 h-8 rounded-xl flex items-center justify-center text-gray-400 border border-gray-200 hover:bg-red-50 hover:text-red-500 hover:border-red-200 transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white border border-gray-100 p-10 rounded-2xl text-center text-gray-400 shadow-sm">
                        <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                            <svg class="h-7 w-7 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <p class="font-semibold text-gray-500 text-sm">Tidak ada pendaftaran seller</p>
                        <p class="text-xs text-gray-400 mt-1">Seller baru yang mendaftar akan muncul di sini.</p>
                    </div>
                    @endforelse

                </div>
            </main>

        </div>
    </div>
</body>

</html>
