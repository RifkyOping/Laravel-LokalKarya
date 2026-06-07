<x-app-layout>

    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-900 leading-tight">Profile Saya</h2>
                <p class="text-sm text-gray-500 font-medium mt-1">Kelola identitas dan tampilan profile publikmu.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Banner peringatan saat redirect dari halaman buat produk --}}
            @if(session('warning'))
                <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl flex items-start gap-3 text-amber-800 animate-pulse-once">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-amber-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                    <div>
                        <p class="font-bold text-sm">{{ session('warning') }}</p>
                        <p class="text-xs text-amber-600 mt-1">Silakan isi semua kolom yang bertanda <span class="font-bold text-red-500">*</span> di bawah ini, lalu simpan.</p>
                    </div>
                </div>
            @endif

            {{-- Indikator profil belum lengkap (selalu tampil jika belum lengkap) --}}
            @if(!Auth::user()->isProfileComplete())
                <div class="p-4 bg-blue-50 border border-blue-200 rounded-2xl flex items-start gap-3 text-blue-800">
                    <svg class="w-5 h-5 shrink-0 mt-0.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <p class="font-bold text-sm">Profil Anda belum lengkap</p>
                        <p class="text-xs text-blue-600 mt-1">Lengkapi data berikut agar dapat membuat produk:
                            @php
                                $profile = Auth::user()->sellerProfile;
                                $missing = [];
                                if (!$profile || empty($profile->nomor_whatsapp)) $missing[] = 'Nomor WhatsApp';
                                if (!$profile || empty($profile->alamat)) $missing[] = 'Alamat';
                                if (!$profile || empty($profile->bidang_keahlian)) $missing[] = 'Bidang Keahlian';
                                if (!$profile || empty($profile->deskripsi)) $missing[] = 'Tentang Saya';
                            @endphp
                            <span class="font-bold">{{ implode(', ', $missing) }}</span>
                        </p>
                    </div>
                </div>
            @endif

            <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem] flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div class="flex items-center gap-6">
                    <img src="{{ Auth::user()->sellerProfile && Auth::user()->sellerProfile->foto ? asset('storage/' . Auth::user()->sellerProfile->foto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name ?? 'Kreator') . '&background=1f2937&color=fff&size=200' }}"
                        loading="lazy" class="w-20 h-20 rounded-[1.25rem] object-cover shadow-sm border-2 border-white">
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 flex items-center gap-1.5">
                            {{ Auth::user()->name ?? 'Seller' }}
                            @if(Auth::user()->sellerProfile && Auth::user()->sellerProfile->status_verifikasi == 'diterima')
                                <svg class="w-6 h-6 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            @endif
                        </h3>
                        <p class="text-gray-500 font-medium text-sm">
                            {{ Auth::user()->sellerProfile->bidang_keahlian ?? '' }}</p>
                    </div>
                </div>
                <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                    <form action="{{ route('seller.profile.photo') }}" method="POST" enctype="multipart/form-data"
                        class="w-full md:w-auto bg-gray-50/50 p-2 rounded-xl border border-gray-200 flex items-center justify-between gap-12 sm:min-w-[320px]">
                        @csrf
                        @method('PATCH')
                        <span class="text-sm text-gray-500 font-medium pl-3">Unggah Foto Profil</span>
                        <input type="file" name="foto" id="foto-input" class="hidden" accept="image/*"
                            onchange="this.form.submit()">
                        <button type="button" onclick="document.getElementById('foto-input').click()"
                            class="bg-white border border-gray-200 text-gray-700 hover:text-gray-900 hover:bg-gray-50 px-5 py-2 rounded-lg text-xs font-bold transition-all shadow-sm">
                            Pilih file
                        </button>
                    </form>
                    @error('foto')
                        <span class="text-red-500 text-xs mt-1 self-start md:self-end">{{ $message }}</span>
                    @enderror
                    @if (session('status') === 'photo-updated')
                        <span class="text-green-600 text-xs font-bold mt-1 self-start md:self-end">Foto berhasil
                            diperbarui!</span>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-2 space-y-6">

                    <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem]">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    
                    <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem]">
                        <form action="{{ route('seller.profile.details') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Bidang Keahlian <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="bidang_keahlian"
                                    value="{{ old('bidang_keahlian', Auth::user()->sellerProfile->bidang_keahlian ?? '') }}"
                                    placeholder="Masukkan bidang keahlian (contoh: Creative Designer)..."
                                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm">
                                @error('bidang_keahlian')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Alamat Lengkap / Link Maps <span class="text-red-500">*</span>
                                </label>
                                
                                <div class="mb-3">
                                    <input type="text" id="alamat-input" name="alamat"
                                        value="{{ old('alamat', Auth::user()->sellerProfile->alamat ?? '') }}"
                                        placeholder="Masukkan alamat manual atau paste link Google Maps..."
                                        class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                </div>
                                <p class="text-xs text-gray-500">
                                    Anda dapat memasukkan teks alamat manual atau <i>paste</i> tautan (link) dari Google Maps langsung.
                                </p>
                                @error('alamat')
                                    <span class="text-red-500 text-xs mt-1 block mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">
                                    Tentang Saya <span class="text-red-500">*</span>
                                </label>
                                <textarea name="tentang_saya" rows="3" placeholder="Ceritakan tentang diri Anda..."
                                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm resize-none">{{ old('tentang_saya', Auth::user()->sellerProfile->deskripsi ?? '') }}</textarea>
                                @error('tentang_saya')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex items-center gap-4 pt-2">
                                <button type="submit"
                                    class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                                    Simpan
                                </button>
                                @if (session('status') === 'details-updated')
                                    <span class="text-sm text-green-600 font-medium ml-4">Tersimpan!</span>
                                @endif
                            </div>
                        </form>
                    </div>

                    <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem]">

                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-6 gap-4">
                            <div>
                                <h2 class="text-xl font-extrabold text-gray-900">Portfolio / Link Karya</h2>
                                <p class="text-xs text-gray-500 font-medium mt-1">Tambahkan tautan menuju karya atau
                                    project yang pernah kamu buat.</p>
                            </div>
                            @if (session('status') === 'portfolio-added')
                                <span class="text-sm text-green-600 font-medium">Link berhasil ditambahkan!</span>
                            @elseif (session('status') === 'portfolio-deleted')
                                <span class="text-sm text-red-600 font-medium">Link berhasil dihapus!</span>
                            @endif
                        </div>

                        <form action="{{ route('seller.portfolio.add') }}" method="POST"
                            class="mb-8 flex flex-col sm:flex-row gap-3 bg-gray-50 p-4 rounded-2xl border border-gray-100">
                            @csrf
                            <div class="flex-1 flex flex-col">
                                <input type="text" name="judul_karya" value="{{ old('judul_karya') }}"
                                    placeholder="Judul Karya (Misal: Dribbble, GDrive)"
                                    class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                @error('judul_karya')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex-1 flex flex-col">
                                <input type="url" name="link_karya" value="{{ old('link_karya') }}"
                                    placeholder="https://..."
                                    class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm">
                                @error('link_karya')
                                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all active:scale-95 whitespace-nowrap self-start sm:self-center">
                                + Tambah Link
                            </button>
                        </form>

                        <div class="space-y-3">

                            @php
                                $portfolios = Auth::user()->sellerProfile->link_portofolio ?? [];
                            @endphp

                            @if (count($portfolios) > 0)
                                @foreach ($portfolios as $index => $item)
                                    <div
                                        class="flex items-center justify-between p-4 rounded-2xl border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50/30 transition-all group">
                                        <div class="flex items-center gap-4 overflow-hidden">
                                            <div
                                                class="w-10 h-10 rounded-full bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 00-5.656 0l-4 4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                    </path>
                                                </svg>
                                            </div>
                                            <div class="truncate">
                                                <h4 class="text-sm font-bold text-gray-900 truncate">
                                                    {{ $item['judul'] ?? 'Link Karya' }}</h4>
                                                <a href="{{ $item['link'] ?? '#' }}" target="_blank"
                                                    class="text-xs font-medium text-blue-600 hover:underline truncate block">{{ $item['link'] ?? '#' }}</a>
                                            </div>
                                        </div>

                                        <form action="{{ route('seller.portfolio.delete', $index) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-gray-400 hover:text-red-500 transition-colors p-2 shrink-0 opacity-0 group-hover:opacity-100">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            @else
                                <div
                                    class="text-center py-6 text-gray-400 font-medium text-sm border-2 border-dashed border-gray-150 rounded-2xl">
                                    Belum ada link portfolio yang ditambahkan.
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem]">
                        @include('profile.partials.update-password-form')
                    </div>

                    <div class="p-8 bg-red-50/30 border border-red-100 shadow-sm rounded-[2rem]">
                        @include('profile.partials.delete-user-form')
                    </div>

                </div>

                <div class="lg:col-span-1 space-y-6">
                    <div class="p-8 bg-white shadow-sm border border-gray-100 rounded-[2rem] sticky top-28">
                        <h2 class="text-xl font-extrabold text-gray-900 mb-6">Kontak</h2>

                        <form id="form-whatsapp" action="{{ route('seller.whatsapp.update') }}" method="POST" class="space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">WhatsApp <span class="text-red-500">*</span></label>

                                <input type="text" id="input-whatsapp" name="nomor_whatsapp"
                                    value="{{ old('nomor_whatsapp', Auth::user()->sellerProfile->nomor_whatsapp ?? '') }}"
                                    placeholder="6281234567890"
                                    inputmode="numeric"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-gray-900 font-medium">

                                <p class="mt-2 text-xs text-gray-500">
                                    *Pastikan nomor diawali dengan kode negara 62, tanpa spasi dan tanpa tanda plus (+).
                                </p>

                                <span id="wa-client-error" class="text-red-500 text-xs mt-1 block hidden"></span>

                                @error('nomor_whatsapp')
                                    <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="flex justify-center pt-2">
                                <button type="submit"
                                    class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95 whitespace-nowrap">
                                    Simpan
                                </button>
                                @if (session('status') === 'whatsapp-updated')
                                    <span class="text-sm text-green-600 text-center font-medium mt-2 ml-6">Tersimpan!</span>
                                @endif
                            </div>
                        </form>

                        <script>
                            document.getElementById('form-whatsapp').addEventListener('submit', function (e) {
                                var val = document.getElementById('input-whatsapp').value.trim();
                                var errEl = document.getElementById('wa-client-error');
                                if (!val.startsWith('62')) {
                                    e.preventDefault();
                                    errEl.textContent = 'Nomor harus diawali dengan 62 (contoh: 6281234567890).';
                                    errEl.classList.remove('hidden');
                                    document.getElementById('input-whatsapp').focus();
                                } else {
                                    errEl.classList.add('hidden');
                                }
                            });
                        </script>

                    </div>
                </div>

            </div>
        </div>
    </div>

</x-app-layout>