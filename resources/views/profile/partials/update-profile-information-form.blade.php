<section>
    <header class="mb-6">
        <h2 class="text-xl font-extrabold text-gray-900">
            Informasi Dasar
        </h2>
        <p class="mt-1 text-sm text-gray-500 font-medium">
            Perbarui informasi profil dan alamat email akun Anda.
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form id="form-info-dasar" method="post"
          action="{{ auth()->user()->role == 'admin' ? route('profile.update') : route('update.seller') }}"
          class="space-y-6"
          data-persist
          data-persist-message="Informasi dasar yang kamu ubah sebelumnya telah dipulihkan. Jangan lupa simpan!">
        @csrf
        @method('patch')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Nama Lengkap')"
                    class="text-xs font-bold text-gray-900 uppercase tracking-wider mb-2" />
                <x-text-input id="name" name="name" type="text"
                    class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                    :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')"
                class="text-xs font-bold text-gray-500 uppercase tracking-wider mb-2" />
            <x-text-input id="email" name="email" type="email"
                class="mt-1 block w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-2">
            <button
                class="bg-[#4F46E5] hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl font-bold text-sm shadow-md shadow-indigo-600/20 transition-all hover:-translate-y-0.5 active:scale-95">
                {{ __('Simpan') }}
            </button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 font-bold bg-green-50 px-4 py-2 rounded-lg">
                    {{ __('Tersimpan.') }}
                </p>
            @endif
        </div>
    </form>
</section>