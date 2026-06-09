<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback Pengguna - LOKALKARYA</title>
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
                <div class="max-w-5xl mx-auto px-4 sm:px-8 py-4 sm:py-5 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg sm:text-xl font-extrabold text-gray-900 tracking-tight">Feedback Pengguna</h2>
                        <p class="text-gray-500 text-xs mt-0.5">Ulasan dan masukan dari pengguna LOKALKARYA.</p>
                    </div>
                    @if($unreadCount > 0)
                        <span class="bg-blue-600 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-sm shadow-blue-600/20">
                            {{ $unreadCount }} belum dibaca
                        </span>
                    @endif
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

                    @if($feedbacks->isEmpty())
                        <div class="bg-white border border-gray-100 p-12 rounded-3xl text-center shadow-sm">
                            <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                <svg class="h-8 w-8 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <p class="font-bold text-gray-700 text-sm">Belum ada feedback</p>
                            <p class="text-xs text-gray-400 mt-1">Feedback dari pengguna akan muncul di sini.</p>
                        </div>
                    @else
                        <!-- Stats row -->
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
                            @php
                                $total = $feedbacks->total();
                                $avgRating = \App\Models\Feedback::avg('rating');
                                $unread = \App\Models\Feedback::where('is_read', false)->count();
                                $fiveStar = \App\Models\Feedback::where('rating', 5)->count();
                            @endphp
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-1">Total Feedback</p>
                                <p class="text-3xl font-extrabold text-gray-900">{{ $total }}</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-1">Rata-rata Rating</p>
                                <p class="text-3xl font-extrabold text-yellow-500">{{ number_format($avgRating, 1) }} <span class="text-lg">⭐</span></p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-1">Belum Dibaca</p>
                                <p class="text-3xl font-extrabold text-blue-600">{{ $unread }}</p>
                            </div>
                            <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                                <p class="text-xs font-bold text-gray-400 mb-1">Bintang 5</p>
                                <p class="text-3xl font-extrabold text-green-600">{{ $fiveStar }}</p>
                            </div>
                        </div>

                        <div class="space-y-3">
                            @foreach($feedbacks as $fb)
                            <div class="bg-white border {{ $fb->is_read ? 'border-gray-100' : 'border-blue-200 shadow-sm shadow-blue-50' }} rounded-2xl p-5 flex flex-col sm:flex-row sm:items-start gap-4 transition-all">

                                <!-- Avatar -->
                                <div class="shrink-0">
                                    <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-extrabold text-base shadow-md">
                                        {{ strtoupper(substr($fb->name, 0, 1)) }}
                                    </div>
                                </div>

                                <!-- Content -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2 mb-1">
                                        <div>
                                            <p class="font-extrabold text-gray-900 text-sm">{{ $fb->name }}</p>
                                            @if($fb->email)
                                                <p class="text-xs text-gray-400">{{ $fb->email }}</p>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1.5 shrink-0">
                                            @if(!$fb->is_read)
                                                <span class="w-2 h-2 rounded-full bg-blue-500 shrink-0"></span>
                                            @endif
                                            <span class="text-xs font-bold text-gray-400">{{ $fb->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>

                                    <!-- Stars -->
                                    <div class="flex items-center gap-0.5 mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fb->rating)
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-200" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                            @endif
                                        @endfor
                                        <span class="text-xs font-bold text-gray-500 ml-1">{{ $fb->rating }}/5</span>
                                    </div>

                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $fb->message }}</p>

                                    <!-- Actions -->
                                    <div class="flex items-center gap-2 mt-3">
                                        @if(!$fb->is_read)
                                            <form action="{{ route('admin.feedback.read', $fb->id) }}" method="POST">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="text-xs font-bold text-blue-600 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition-colors">
                                                    Tandai Dibaca
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs font-bold text-green-600 bg-green-50 px-3 py-1.5 rounded-lg">✓ Dibaca</span>
                                        @endif
                                        <button type="button"
                                            onclick="openDeleteModal('{{ route('admin.feedback.destroy', $fb->id) }}', 'Hapus Feedback?', 'Feedback dari {{ addslashes($fb->name) }} akan dihapus permanen.')"
                                            class="text-xs font-bold text-red-500 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition-colors">
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $feedbacks->links() }}
                        </div>
                    @endif

                </div>
            </main>
        </div>
    </div>
</body>

</html>
