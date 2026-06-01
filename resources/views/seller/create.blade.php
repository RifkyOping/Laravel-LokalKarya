<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">
            Tambah Jasa / Produk
        </h2>
        <p class="text-sm text-gray-500 font-medium mt-1">
            Tambahkan layanan kreatif untuk ditampilkan di platform.
        </p>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('seller.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                @if ($errors->any())
                <div class="p-6 bg-red-50 border border-red-200 rounded-[1.5rem] mb-6 shadow-sm">
                    <div class="flex items-center gap-3 text-red-700 mb-3">
                        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <span class="font-extrabold text-sm">Terjadi Kesalahan Pengisian Form:</span>
                    </div>
                    <ul class="list-disc list-inside text-xs text-red-600 space-y-1 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem]">
                    <h3 class="text-xl font-extrabold text-gray-900 mb-8">Informasi Jasa</h3>

                    <div class="space-y-6">
                        <div>
                            <label for="name" class="block text-[13px] font-bold text-gray-700 mb-2">Nama Jasa /
                                Produk</label>
                            <input type="text" id="name" name="name"
                                placeholder="Contoh: Desain Poster Event Kampus"
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5">
                        </div>

                        <div>
                            <label for="category"
                                class="block text-[13px] font-bold text-gray-700 mb-2">Kategori</label>
                            <select id="category" name="category"
                                class="block w-full rounded-xl border-gray-200 bg-indigo-50/40 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5 text-gray-700">
                                <option value="" disabled selected>Pilih kategori</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-[13px] font-bold text-gray-700 mb-2">Harga</label>
                            <input type="number" id="price" name="price" placeholder="Contoh: 75000"
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5">
                        </div>

                        <div>
                            <label for="description"
                                class="block text-[13px] font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="5"
                                placeholder="Jelaskan jasa atau produk yang kamu tawarkan..."
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm resize-none"></textarea>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem] space-y-5">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Thumbnail</h3>
                        <p class="text-sm text-gray-500 font-medium mt-1">Upload gambar terbaik atau masukkan link gambar untuk menarik perhatian pembeli.</p>
                    </div>

                    {{-- Tab Toggle --}}
                    <div class="flex gap-2 p-1 bg-gray-100 rounded-xl w-fit">
                        <button type="button" id="tab-upload"
                            onclick="switchTab('upload')"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-indigo-600 shadow-sm">
                            📁 Upload File
                        </button>
                        <button type="button" id="tab-url"
                            onclick="switchTab('url')"
                            class="px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700">
                            🔗 Link URL
                        </button>
                    </div>

                    {{-- Panel: Upload File --}}
                    <div id="panel-upload">
                        <label class="block text-[13px] font-bold text-gray-700 mb-2">Upload dari Perangkat</label>
                        <div class="relative flex items-center gap-4">
                            <div class="relative">
                                <input type="file" id="thumbnail" name="thumbnail" onchange="previewFromFile(event)"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                                <button type="button"
                                    class="bg-indigo-50 border border-indigo-200 text-indigo-700 px-6 py-2.5 rounded-xl font-semibold text-sm transition-all hover:bg-indigo-100 hover:-translate-y-0.5 active:scale-95">
                                    Pilih Gambar
                                </button>
                            </div>
                            <span id="file-name" class="text-sm text-gray-400 italic">Belum ada file dipilih</span>
                        </div>
                    </div>

                    {{-- Panel: Link URL --}}
                    <div id="panel-url" class="hidden">
                        <label for="thumbnail_url" class="block text-[13px] font-bold text-gray-700 mb-2">Link Gambar (Google Drive / URL langsung)</label>
                        <input type="url" id="thumbnail_url" name="thumbnail_url"
                            placeholder="https://google.com/uc?export=view&id=..."
                            oninput="previewFromUrl(this.value)"
                            class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5">
                        <p class="mt-2 text-xs text-gray-400">
                            Note: Gunakan Link Public  
                        </p>
                    </div>

                    {{-- Preview --}}
                    <div id="preview-container" class="hidden">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Preview Thumbnail:</p>
                        <div class="relative w-fit">
                            <img id="image-preview" src="" alt="Preview Thumbnail"
                                class="w-56 h-36 object-cover rounded-xl border border-gray-200 shadow-sm">
                            <button type="button" onclick="clearPreview()"
                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 text-xs font-bold hover:bg-red-600 transition-colors flex items-center justify-center">
                                ✕
                            </button>
                        </div>
                    </div>
                </div>
                <div class="pt-4">
                    <button type="submit"
                        class=" bg-[#4F46E5] hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                        Simpan Jasa
                    </button>
                </div>

            </form>
        </div>
    </div>

    <script>
        // ── Tab Switching ──────────────────────────────────────────
        function switchTab(tab) {
            const isUpload = tab === 'upload';

            // Tab button styles
            document.getElementById('tab-upload').className = isUpload
                ? 'px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-indigo-600 shadow-sm'
                : 'px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700';
            document.getElementById('tab-url').className = !isUpload
                ? 'px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 bg-white text-indigo-600 shadow-sm'
                : 'px-5 py-2 rounded-lg text-sm font-semibold transition-all duration-200 text-gray-500 hover:text-gray-700';

            // Panel visibility
            document.getElementById('panel-upload').classList.toggle('hidden', !isUpload);
            document.getElementById('panel-url').classList.toggle('hidden', isUpload);

            // Disable inactive inputs so they don't interfere with validation
            document.getElementById('thumbnail').disabled = !isUpload;
            document.getElementById('thumbnail_url').disabled = isUpload;

            // Clear preview when switching
            clearPreview();
        }

        // ── Preview from local file ────────────────────────────────
        function previewFromFile(event) {
            const input = event.target;
            const fileName = document.getElementById('file-name');

            if (input.files && input.files[0]) {
                fileName.textContent = input.files[0].name;
                fileName.classList.remove('italic', 'text-gray-400');
                fileName.classList.add('text-gray-700', 'font-medium');

                const reader = new FileReader();
                reader.onload = function(e) {
                    showPreview(e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                fileName.textContent = 'Belum ada file dipilih';
                fileName.classList.add('italic', 'text-gray-400');
                fileName.classList.remove('text-gray-700', 'font-medium');
                clearPreview();
            }
        }

        // ── Preview from URL ───────────────────────────────────────
        function previewFromUrl(url) {
            if (url && url.trim() !== '') {
                showPreview(url.trim());
            } else {
                clearPreview();
            }
        }

        // ── Helpers ────────────────────────────────────────────────
        function showPreview(src) {
            const img = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            img.src = src;
            container.classList.remove('hidden');
        }

        function clearPreview() {
            const img = document.getElementById('image-preview');
            const container = document.getElementById('preview-container');
            img.src = '';
            container.classList.add('hidden');

            // Also reset file input & label
            const fileInput = document.getElementById('thumbnail');
            if (fileInput) fileInput.value = '';
            const fileName = document.getElementById('file-name');
            if (fileName) {
                fileName.textContent = 'Belum ada file dipilih';
                fileName.classList.add('italic', 'text-gray-400');
                fileName.classList.remove('text-gray-700', 'font-medium');
            }

            // Also reset url input
            const urlInput = document.getElementById('thumbnail_url');
            if (urlInput) urlInput.value = '';
        }

        // Init: make sure URL input is disabled on page load
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('thumbnail_url').disabled = true;
        });
    </script>
</x-app-layout>
