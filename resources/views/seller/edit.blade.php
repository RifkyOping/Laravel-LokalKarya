<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">
            Edit Jasa / Produk
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <form action="{{ route('seller.update', $produk->id) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT') @if ($errors->any())
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
                            <label for="name" class="block text-[13px] font-bold text-gray-700 mb-2">Nama Jasa / Produk</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $produk->name) }}"
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5">
                        </div>

                        <div>
                            <label for="category" class="block text-[13px] font-bold text-gray-700 mb-2">Kategori</label>
                            <select id="category" name="category"
                                class="block w-full rounded-xl border-gray-200 bg-indigo-50/40 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5 text-gray-700">
                                <option value="desain-publikasi" {{ old('category', $produk->category) == 'desain-publikasi' ? 'selected' : '' }}>Desain Publikasi</option>
                                <option value="ui-design" {{ old('category', $produk->category) == 'ui-design' ? 'selected' : '' }}>UI Design</option>
                                <option value="social-media" {{ old('category', $produk->category) == 'social-media' ? 'selected' : '' }}>Social Media</option>
                                <option value="web-development" {{ old('category', $produk->category) == 'web-development' ? 'selected' : '' }}>Web Development</option>
                                <option value="video-editing" {{ old('category', $produk->category) == 'video-editing' ? 'selected' : '' }}>Video Editing</option>
                            </select>
                        </div>

                        <div>
                            <label for="price" class="block text-[13px] font-bold text-gray-700 mb-2">Harga</label>
                            <input type="number" id="price" name="price" value="{{ old('price', $produk->price) }}"
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm py-2.5">
                        </div>

                        <div>
                            <label for="description" class="block text-[13px] font-bold text-gray-700 mb-2">Deskripsi</label>
                            <textarea id="description" name="description" rows="5"
                                class="block w-full rounded-xl border-gray-200 focus:border-[#4F46E5] focus:ring-[#4F46E5] shadow-sm text-sm resize-none">{{ old('description', $produk->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem] flex flex-col sm:flex-row sm:items-start justify-between gap-6 relative">
                    <div>
                        <h3 class="text-xl font-extrabold text-gray-900">Thumbnail</h3>
                        <p class="text-sm text-gray-500 font-medium mt-1">Kosongkan jika tidak ingin mengubah gambar thumbnail.</p>

                        <div id="preview-container" class="mt-6">
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Preview Thumbnail:</p>
                            <img id="image-preview" 
                                 src="{{ $produk->thumbnail ? asset('storage/' . $produk->thumbnail) : '' }}" 
                                 alt="Preview Thumbnail"
                                 class="w-48 h-32 object-cover rounded-xl border border-gray-200 shadow-sm">
                        </div>
                    </div>

                    <div class="relative flex items-center justify-center shrink-0 mt-2">
                        <input type="file" id="thumbnail" name="thumbnail" onchange="previewImage(event)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" accept="image/*">
                        <button type="button"
                            class="text-black px-8 py-3 rounded-xl font-medium text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                            Ubah file
                        </button>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit"
                        class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-8 py-3 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                        Perbarui Jasa
                    </button>
                    <a href="{{ route('seller.index') }}" class="ml-3 text-sm font-semibold text-gray-600 hover:text-gray-900">Batal</a>
                </div>

            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const previewImage = document.getElementById('image-preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>