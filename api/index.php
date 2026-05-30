<?php
// 1. HANCURKAN CACHE LOKAL: Hapus paksa cache lama dari laptop Anda
$cacheFiles = [
    __DIR__ . '/../bootstrap/cache/config.php',
    __DIR__ . '/../bootstrap/cache/routes.php',
    __DIR__ . '/../bootstrap/cache/events.php',
    __DIR__ . '/../bootstrap/cache/packages.php',
    __DIR__ . '/../bootstrap/cache/services.php',
];
foreach ($cacheFiles as $file) {
    if (file_exists($file)) {
        unlink($file);
    }
}

// 2. BANGUN FOLDER: Siapkan kerangka storage di dalam /tmp Vercel
$dirs = [
    '/tmp/framework/views',
    '/tmp/framework/cache/data',
    '/tmp/framework/sessions',
    '/tmp/logs',
    '/tmp/bootstrap/cache'
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }
}

// 3. PAKSA DEBUG: Paksa Laravel menampilkan pesan error secara detail
$_ENV['APP_DEBUG'] = 'true';
putenv('APP_DEBUG=true');
$_ENV['APP_ENV'] = 'local';
putenv('APP_ENV=local');

// 4. Nyalakan mesin Laravel dengan mulus
require __DIR__ . '/../public/index.php';