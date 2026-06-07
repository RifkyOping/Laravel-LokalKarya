<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atur Ulang Kata Sandi - LOKALKARYA</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans antialiased text-gray-900">
    <div class="min-h-screen flex flex-col justify-center items-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Logo Section -->
        <div class="animate-fade-in-up">
            <a href="{{ url('/') }}" class="flex items-center gap-2 mb-8 group">
                <x-logo class="h-14 w-auto object-contain" />
            </a>
        </div>

        <!-- Reset Password Card -->
        <div class="w-full max-w-md bg-white shadow-2xl shadow-gray-200/50 rounded-3xl p-8 md:p-10 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Atur Ulang Kata Sandi</h2>
                <p class="text-sm text-gray-500 mt-2">Silakan masukkan kata sandi baru Anda di bawah ini untuk memulihkan akses ke akun Anda.</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-6" :status="session('status')" />

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">Email Terdaftar</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-600 focus:ring-blue-600 transition-all placeholder:text-gray-400"
                        placeholder="email@anda.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1.5">Kata Sandi Baru</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-600 focus:ring-blue-600 transition-all placeholder:text-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1.5">Konfirmasi Kata Sandi Baru</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border-gray-200 bg-gray-50 text-sm focus:border-blue-600 focus:ring-blue-600 transition-all placeholder:text-gray-400"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-600/20 transition-all active:scale-[0.98] text-sm">
                        Simpan Kata Sandi Baru
                    </button>
                </div>
            </form>
        </div>

        <div class="mt-8 animate-fade-in-up" style="animation-delay: 0.2s;">
            <a href="{{ url('/') }}" class="text-xs font-semibold text-gray-400 hover:text-blue-600 transition-all flex items-center gap-1.5">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Beranda
            </a>
        </div>
    </div>
</body>
</html>
