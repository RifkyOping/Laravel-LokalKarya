<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Cek apakah aplikasi sedang berjalan di Vercel
$isVercel = isset($_SERVER['VERCEL']) || isset($_ENV['VERCEL']);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) use ($isVercel): void {
        // Hanya paksa HTTPS jika sedang berada di Vercel
        if ($isVercel) {
            $middleware->trustProxies(at: '*');
        }

        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'profile.complete' => \App\Http\Middleware\EnsureProfileComplete::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create()->useStoragePath($isVercel ? '/tmp' : storage_path());