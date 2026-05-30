<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; // 1. Tambahkan baris ini

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
<<<<<<< HEAD

=======
    // public function boot(): void
    // {
    //     // 2. Paksa HTTPS jika aplikasi berjalan di server Vercel
    //     if (env('APP_ENV') !== 'local') {
    //         URL::forceScheme('https');
    //     }
    // }
>>>>>>> d2ef46ab370f1693f4436f1c3ad7239ab1c3edb3
    public function boot(): void
    {
        // Paksa HTTPS HANYA jika server mendeteksi Vercel
        if (isset($_SERVER['VERCEL'])) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}