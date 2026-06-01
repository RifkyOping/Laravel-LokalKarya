<?php

/**
 * Helper: Resolve URL gambar produk.
 *
 * Jika gambar_produk sudah berupa URL eksternal (http/https), kembalikan langsung.
 * Jika berupa path lokal (storage), bungkus dengan asset('storage/...').
 */
if (!function_exists('produk_image_url')) {
    function produk_image_url(?string $gambar, string $fallback = ''): string
    {
        if (!$gambar) {
            return $fallback;
        }
        // Sudah URL eksternal → langsung pakai
        if (str_starts_with($gambar, 'http://') || str_starts_with($gambar, 'https://')) {
            return $gambar;
        }
        // Path lokal di storage
        return asset('storage/' . $gambar);
    }
}
