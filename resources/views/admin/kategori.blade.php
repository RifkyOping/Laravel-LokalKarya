<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kelola Kategori - LOKALKARYA</title>
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
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-4 sm:py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Kelola Kategori</h2>
                        <p class="text-gray-500 text-xs mt-0.5">Tambah, ubah, atau hapus kategori jasa & produk.</p>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto">
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-6 pb-28 lg:pb-10 space-y-6">

                    {{-- Flash Messages --}}
                    @if(session('success'))
                    <div class="p-3.5 bg-green-50 border border-green-200 rounded-2xl flex items-center gap-3 text-green-700">
                        <svg class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="text-xs sm:text-sm font-bold">{{ session('success') }}</span>
                    </div>
                    @endif

                    @if ($errors->any())
                    <div class="p-4 bg-red-50 border border-red-200 rounded-2xl text-red-700">
                        <p class="font-bold text-sm mb-1">Terjadi kesalahan:</p>
                        <ul class="list-disc list-inside text-xs space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                        {{-- Form Tambah Kategori --}}
                        <div class="lg:col-span-1">
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                                <h3 class="font-extrabold text-gray-900 text-base mb-4 flex items-center gap-2">
                                    <span class="w-7 h-7 bg-indigo-100 text-indigo-600 rounded-lg flex items-center justify-center text-sm">+</span>
                                    Tambah Kategori
                                </h3>
                                <form action="{{ route('admin.kategori.store') }}" method="POST" class="space-y-4">
                                    @csrf
                                    <div>
                                        <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Nama Kategori</label>
                                        <input type="text" name="nama" value="{{ old('nama') }}"
                                            placeholder="Contoh: Motion Graphic"
                                            class="block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm py-2.5">
                                    </div>
                                    <div>
                                        <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Slug <span class="font-normal text-gray-400">(otomatis)</span></label>
                                        <input type="text" name="slug" id="slug-input" value="{{ old('slug') }}"
                                            placeholder="motion-graphic"
                                            class="block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm py-2.5 font-mono text-xs">
                                        <p class="text-[11px] text-gray-400 mt-1">Digunakan sebagai value filter. Kosongkan untuk dibuat otomatis.</p>
                                    </div>
                                    <button type="submit"
                                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-sm shadow-sm transition-all hover:-translate-y-0.5 active:scale-95">
                                        Simpan Kategori
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Daftar Kategori --}}
                        <div class="lg:col-span-2">
                            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                                <div class="px-5 py-4 border-b border-gray-50 flex items-center justify-between">
                                    <h3 class="font-extrabold text-gray-900 text-base">Daftar Kategori</h3>
                                    <span class="text-xs font-bold text-gray-400">{{ $categories->count() }} kategori</span>
                                </div>

                                @if($categories->isEmpty())
                                <div class="py-12 text-center text-gray-400">
                                    <div class="w-12 h-12 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                        <svg class="h-6 w-6 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium">Belum ada kategori. Tambahkan di form sebelah.</p>
                                </div>
                                @else
                                <div class="divide-y divide-gray-50">
                                    @foreach($categories as $cat)
                                    <div class="px-5 py-3.5 flex items-center gap-3 group hover:bg-gray-50/60 transition-colors">
                                        {{-- Status dot --}}
                                        <span class="w-2 h-2 rounded-full shrink-0 {{ $cat->is_active ? 'bg-green-400' : 'bg-gray-300' }}"></span>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-gray-900 text-sm leading-tight">{{ $cat->nama }}</p>
                                            <p class="text-[11px] font-mono text-gray-400 mt-0.5">{{ $cat->slug }}</p>
                                        </div>

                                        {{-- Status Badge --}}
                                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full {{ $cat->is_active ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                            {{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}
                                        </span>

                                        {{-- Actions --}}
                                        <div class="flex items-center gap-1.5 opacity-0 group-hover:opacity-100 transition-opacity">
                                            {{-- Toggle aktif/nonaktif --}}
                                            <form action="{{ route('admin.kategori.toggle', $cat->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit"
                                                    title="{{ $cat->is_active ? 'Nonaktifkan' : 'Aktifkan' }}"
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-indigo-50 hover:text-indigo-600 transition-colors">
                                                    @if($cat->is_active)
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/></svg>
                                                    @else
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    @endif
                                                </button>
                                            </form>

                                            {{-- Edit --}}
                                            <button type="button"
                                                onclick="openEditModal({{ $cat->id }}, '{{ addslashes($cat->nama) }}', '{{ $cat->slug }}')"
                                                title="Edit"
                                                class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>

                                            {{-- Hapus --}}
                                            <form action="{{ route('admin.kategori.destroy', $cat->id) }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus kategori \"{{ addslashes($cat->nama) }}\"?')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    title="Hapus"
                                                    class="w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>

    {{-- Modal Edit Kategori --}}
    <div id="edit-modal" class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 hidden flex items-center justify-center px-4">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <h3 class="font-extrabold text-gray-900 text-base mb-5">Edit Kategori</h3>
            <form id="edit-form" method="POST" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Nama Kategori</label>
                    <input type="text" name="nama" id="edit-nama"
                        class="block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm py-2.5">
                </div>
                <div>
                    <label class="block text-[13px] font-bold text-gray-700 mb-1.5">Slug</label>
                    <input type="text" name="slug" id="edit-slug"
                        class="block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm py-2.5 font-mono text-xs">
                </div>
                <div class="flex gap-3 pt-1">
                    <button type="submit"
                        class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95">
                        Simpan Perubahan
                    </button>
                    <button type="button" onclick="closeEditModal()"
                        class="flex-1 border border-gray-200 text-gray-600 hover:bg-gray-50 py-2.5 rounded-xl font-bold text-sm transition-all active:scale-95">
                        Batal
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Auto-generate slug dari nama
        const namaInput = document.querySelector('input[name="nama"]');
        const slugInput = document.getElementById('slug-input');

        if (namaInput && slugInput) {
            namaInput.addEventListener('input', function () {
                if (!slugInput.dataset.manual) {
                    slugInput.value = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .trim()
                        .replace(/\s+/g, '-');
                }
            });
            slugInput.addEventListener('input', function () {
                this.dataset.manual = this.value ? '1' : '';
            });
        }

        // Edit Modal
        const editModal = document.getElementById('edit-modal');
        const editForm  = document.getElementById('edit-form');
        const baseUrl   = '{{ url("admin/kategori") }}';

        function openEditModal(id, nama, slug) {
            document.getElementById('edit-nama').value = nama;
            document.getElementById('edit-slug').value = slug;
            editForm.action = baseUrl + '/' + id;
            editModal.classList.remove('hidden');
        }

        function closeEditModal() {
            editModal.classList.add('hidden');
        }

        editModal.addEventListener('click', function(e) {
            if (e.target === editModal) closeEditModal();
        });
    </script>
</body>
</html>
