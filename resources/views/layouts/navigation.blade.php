<!-- Mobile overlay backdrop -->
<div x-show="sidebarOpen"
    class="fixed inset-0 z-40 bg-gray-900/60 backdrop-blur-sm lg:hidden"
    @click="sidebarOpen = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0"
    style="display: none;"></div>

<!-- Sidebar -->
<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="fixed inset-y-0 left-0 z-50 w-72 bg-white flex flex-col transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 lg:h-screen lg:sticky lg:top-0 shadow-2xl lg:shadow-none border-r border-gray-100">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between px-6 pt-6 pb-4 border-b border-gray-50">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-blue-600/20">L</div>
            <span class="font-extrabold text-xl tracking-tight text-gray-900 uppercase">Lokalkarya</span>
        </div>
        <button @click="sidebarOpen = false"
            class="lg:hidden w-8 h-8 flex items-center justify-center text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all">
            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- User Badge (Mobile only) -->
    <div class="lg:hidden px-4 py-3 mx-4 mt-4 bg-blue-50 rounded-2xl">
        <div class="flex items-center gap-3">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'User') }}&background=2563eb&color=fff&size=80"
                class="w-10 h-10 rounded-xl object-cover" alt="avatar">
            <div>
                <p class="font-bold text-gray-900 text-sm truncate max-w-[160px]">{{ Auth::user()->name ?? 'User' }}</p>
                <p class="text-xs text-blue-600 font-semibold capitalize">{{ Auth::user()->role ?? 'user' }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">

        @if (Auth::user()->role === 'seller')
            <a href="{{ route('seller.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
               {{ request()->routeIs('seller.dashboard') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
                @if(request()->routeIs('seller.dashboard'))
                <span class="ml-auto w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                @endif
            </a>

            <a href="{{ route('produk.seller') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
               {{ request()->routeIs('produk.seller') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Jasa/Produk Saya
                @if(request()->routeIs('produk.seller'))
                <span class="ml-auto w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                @endif
            </a>

            <a href="{{ route('profile.seller') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
               {{ request()->routeIs('profile.seller') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profil Saya
                @if(request()->routeIs('profile.seller'))
                <span class="ml-auto w-1.5 h-1.5 bg-blue-600 rounded-full"></span>
                @endif
            </a>


        @elseif (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
               {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.seller') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
           {{ request()->routeIs('admin.seller') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                Verifikasi Seller
            </a>

            <a href="{{ route('admin.produk') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
       {{ request()->routeIs('admin.produk') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                Verifikasi Produk
            </a>

            <a href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-3.5 rounded-2xl font-semibold text-sm transition-all
       {{ request()->routeIs('profile.edit') ? 'text-blue-600 bg-blue-50 shadow-sm' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Profil Admin
            </a>
        @endif

    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-gray-50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="flex items-center gap-3 w-full px-4 py-3 text-red-500 hover:text-red-600 hover:bg-red-50 rounded-2xl font-semibold text-sm transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                Keluar
            </button>
        </form>
    </div>
</aside>

<!-- Mobile Bottom Navigation Bar -->
<nav class="fixed bottom-0 left-0 right-0 z-40 bg-white border-t border-gray-100 lg:hidden safe-area-bottom shadow-[0_-4px_20px_rgba(0,0,0,0.08)]">
    <div class="flex items-center justify-around px-2 py-2">

        @if (Auth::user()->role === 'seller')
            <a href="{{ route('seller.dashboard') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('seller.dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="{{ request()->routeIs('seller.dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] font-semibold">Beranda</span>
            </a>

            <a href="{{ route('produk.seller') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('produk.seller') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="{{ request()->routeIs('produk.seller') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="text-[10px] font-semibold">Jasa</span>
            </a>

            <a href="{{ route('seller.create') }}"
                class="flex flex-col items-center gap-0.5">
                <div class="w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-600/30 -mt-5 border-4 border-white">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4" />
                    </svg>
                </div>
                <span class="text-[10px] font-semibold text-blue-600">Tambah</span>
            </a>

            <a href="{{ route('profile.seller') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('profile.seller') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="{{ request()->routeIs('profile.seller') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="text-[10px] font-semibold">Profil</span>
            </a>

            <button @click="sidebarOpen = true"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-[10px] font-semibold">Menu</span>
            </button>

        @elseif (Auth::user()->role === 'admin')
            <a href="{{ route('admin.dashboard') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="{{ request()->routeIs('admin.dashboard') ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="text-[10px] font-semibold">Dashboard</span>
            </a>

            <a href="{{ route('admin.seller') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('admin.seller') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                </svg>
                <span class="text-[10px] font-semibold">Seller</span>
            </a>

            <a href="{{ route('admin.produk') }}"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl transition-all {{ request()->routeIs('admin.produk') ? 'text-blue-600' : 'text-gray-400' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3" />
                </svg>
                <span class="text-[10px] font-semibold">Produk</span>
            </a>

            <button @click="sidebarOpen = true"
                class="flex flex-col items-center gap-0.5 px-3 py-1.5 rounded-xl text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span class="text-[10px] font-semibold">Menu</span>
            </button>
        @endif

</nav>

{{-- ═══════════════════════════════════════════════════════════════
     GLOBAL DELETE CONFIRMATION MODAL
     Usage: onclick="openDeleteModal(formAction, title, description)"
     ═══════════════════════════════════════════════════════════════ --}}
<div id="delete-modal"
     class="fixed inset-0 z-[999] flex items-center justify-center px-4"
     style="display:none!important;"
     aria-modal="true" role="dialog">

    {{-- Backdrop --}}
    <div id="delete-backdrop"
         class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm"
         onclick="closeDeleteModal()"></div>

    {{-- Panel --}}
    <div id="delete-panel"
         class="relative bg-white rounded-3xl shadow-2xl w-full max-w-sm p-7 flex flex-col items-center text-center
                transition-all duration-300 scale-90 opacity-0">

        {{-- Icon --}}
        <div class="w-16 h-16 bg-red-100 rounded-2xl flex items-center justify-center mb-5 ring-8 ring-red-50">
            <svg class="w-8 h-8 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        {{-- Title --}}
        <h3 id="delete-modal-title" class="text-lg font-extrabold text-gray-900 mb-2 leading-snug">
            Hapus Item?
        </h3>

        {{-- Description --}}
        <p id="delete-modal-desc" class="text-sm text-gray-500 font-medium mb-7 leading-relaxed">
            Tindakan ini tidak dapat dibatalkan.
        </p>

        {{-- Hidden form --}}
        <form id="delete-modal-form" method="POST" class="w-full">
            @csrf
            @method('DELETE')
            <div class="flex gap-3 w-full">
                <button type="button" onclick="closeDeleteModal()"
                    class="flex-1 py-3 rounded-2xl font-bold text-sm text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all active:scale-95">
                    Batal
                </button>
                <button type="submit"
                    class="flex-1 py-3 rounded-2xl font-bold text-sm text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5 active:scale-95">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

<script>
(function () {
    const modal    = document.getElementById('delete-modal');
    const panel    = document.getElementById('delete-panel');
    const form     = document.getElementById('delete-modal-form');
    const titleEl  = document.getElementById('delete-modal-title');
    const descEl   = document.getElementById('delete-modal-desc');

    window.openDeleteModal = function (action, title, description) {
        form.action  = action;
        titleEl.textContent = title || 'Hapus Item?';
        descEl.textContent  = description || 'Tindakan ini tidak dapat dibatalkan.';

        modal.style.removeProperty('display');
        document.body.style.overflow = 'hidden';

        // Trigger animation
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                panel.classList.remove('scale-90', 'opacity-0');
                panel.classList.add('scale-100', 'opacity-100');
            });
        });
    };

    window.closeDeleteModal = function () {
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-90', 'opacity-0');
        setTimeout(() => {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }, 250);
    };

    // Close on Escape key
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') closeDeleteModal();
    });
})();
</script>
