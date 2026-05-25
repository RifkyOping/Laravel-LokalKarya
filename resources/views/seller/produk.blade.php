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
    <div class="flex min-h-screen">

        @include('layouts.navigation')

        <div class="flex-1 flex flex-col min-w-0">

            <header class="bg-white border-b border-gray-100 sticky top-0 z-20 shadow-sm">
                <div class="max-w-6xl mx-auto px-8 py-5">
                    <h2 class="text-xl font-extrabold text-gray-900 tracking-tight">
                        Produk & Jasa
                    </h2>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-[1400px] mx-auto p-8 md:p-12">

                    @if(session('success'))
                    <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 text-green-700 animate-fade-in">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-bold">{{ session('success') }}</span>
                    </div>
                    @endif

                    <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm mb-8 p-5 flex items-center">
                        <a href="{{ route('seller.create') }}"
                            class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-6 py-3 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                            + Tambah Jasa
                        </a>
                    </div>

                    <!-- Jasa Disetujui -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-green-500"></span>
                        <h3 class="font-extrabold text-gray-800 text-lg tracking-tight">Jasa Disetujui (Aktif)</h3>
                    </div>
                    <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm mb-12 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[1000px] table-fixed">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/30">
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-32">
                                            Thumbnail</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/3">
                                            Nama Jasa</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Kategori</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Harga</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide text-center w-48">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($produksDiterima as $produk)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image' }}"
                                                class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-gray-900 text-sm break-words">
                                            {{ $produk->nama_produk }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-blue-50 text-blue-600 font-bold text-[11px] rounded-full">
                                                {{ ucwords(str_replace('-', ' ', $produk->kategori)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-[#4F46E5] text-sm">
                                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-green-50 text-green-600 font-bold text-[11px] rounded-full">
                                                Disetujui
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-3">
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-[#4F46E5] hover:text-[#4F46E5] transition-all active:scale-95">Edit</button>
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-red-600 hover:text-red-600 transition-all active:scale-95">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                            </svg>
                                            <p class="font-semibold text-gray-500 text-sm">Belum ada jasa yang disetujui</p>
                                            <p class="text-xs text-gray-400 mt-1">Jasa yang lolos verifikasi admin akan muncul di sini.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Menunggu Verifikasi -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-yellow-500"></span>
                        <h3 class="font-extrabold text-gray-800 text-lg tracking-tight">Menunggu Verifikasi</h3>
                    </div>
                    <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm mb-12 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[1000px] table-fixed">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/30">
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-32">
                                            Thumbnail</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/3">
                                            Nama Jasa</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Kategori</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Harga</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide text-center w-48">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($produksMenunggu as $produk)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image' }}"
                                                class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-gray-900 text-sm break-words">
                                            {{ $produk->nama_produk }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-blue-50 text-blue-600 font-bold text-[11px] rounded-full">
                                                {{ ucwords(str_replace('-', ' ', $produk->kategori)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-[#4F46E5] text-sm">
                                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-yellow-50 text-yellow-600 font-bold text-[11px] rounded-full">
                                                Menunggu
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-3">
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-[#4F46E5] hover:text-[#4F46E5] transition-all active:scale-95">Edit</button>
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-red-600 hover:text-red-600 transition-all active:scale-95">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="font-semibold text-gray-500 text-sm">Tidak ada jasa yang menunggu verifikasi</p>
                                            <p class="text-xs text-gray-400 mt-1">Jasa baru yang ditambahkan sedang ditinjau oleh Admin.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Jasa Ditolak -->
                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                        <h3 class="font-extrabold text-gray-800 text-lg tracking-tight">Jasa Ditolak</h3>
                    </div>
                    <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm mb-8 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse min-w-[1000px] table-fixed">
                                <thead>
                                    <tr class="border-b border-gray-100 bg-gray-50/30">
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-32">
                                            Thumbnail</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/3">
                                            Nama Jasa</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Kategori</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Harga</th>
                                        <th class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide w-1/5">
                                            Status</th>
                                        <th
                                            class="px-6 py-4 text-gray-500 font-bold text-[13px] tracking-wide text-center w-48">
                                            Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @forelse($produksDitolak as $produk)
                                    <tr class="hover:bg-gray-50/80 transition-colors">
                                        <td class="px-6 py-4">
                                            <img src="{{ $produk->gambar_produk ? asset('storage/' . $produk->gambar_produk) : 'https://placehold.co/150x150/e2e8f0/64748b?text=No+Image' }}"
                                                class="w-16 h-16 rounded-2xl object-cover border border-gray-100">
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-gray-900 text-sm break-words">
                                            {{ $produk->nama_produk }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-blue-50 text-blue-600 font-bold text-[11px] rounded-full">
                                                {{ ucwords(str_replace('-', ' ', $produk->kategori)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 font-extrabold text-[#4F46E5] text-sm">
                                            Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-4">
                                            <span
                                                class="inline-flex items-center justify-center px-4 py-1.5 bg-red-50 text-red-600 font-bold text-[11px] rounded-full">
                                                Ditolak
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-3">
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-[#4F46E5] hover:text-[#4F46E5] transition-all active:scale-95">Edit</button>
                                                <button
                                                    class="px-5 py-2.5 rounded-xl font-bold text-xs bg-white text-gray-700 border border-gray-200 hover:border-red-600 hover:text-red-600 transition-all active:scale-95">Hapus</button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                            <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            <p class="font-semibold text-gray-500 text-sm">Tidak ada jasa yang ditolak</p>
                                            <p class="text-xs text-gray-400 mt-1">Layanan Anda berjalan dengan baik tanpa ada penolakan.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>

</html>
