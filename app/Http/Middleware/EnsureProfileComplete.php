<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     *
     * Pastikan seller sudah melengkapi profil sebelum bisa membuat produk.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->role === 'seller' && !$user->isProfileComplete()) {
            return redirect()
                ->route('profile.seller')
                ->with('warning', 'Lengkapi profil Anda terlebih dahulu sebelum membuat produk. Pastikan Nomor WhatsApp, Alamat, Bidang Keahlian, dan Tentang Saya sudah terisi.');
        }

        return $next($request);
    }
}
