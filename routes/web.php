<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', [WelcomeController::class, 'index'])->name('home');
Route::get('/jasa/{id}', [WelcomeController::class, 'show'])->name('produk.detail');

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'seller') {
        return redirect()->route('seller.dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// ─── Routes untuk Seller ─────────────────────────────────────────────
Route::middleware(['auth', 'role:seller'])->group(function () {
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');

    Route::get('/seller/produk', [ProdukController::class, 'index'])->name('produk.seller');
    Route::get('/seller/produk/create', [ProdukController::class, 'create'])->name('seller.create');
    Route::post('/seller/produk', [ProdukController::class, 'store'])->name('seller.store');
    Route::get('/seller/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/produk/{produk}', [ProdukController::class, 'update'])->name('seller.update');
    Route::delete('/seller/produk/{produk}', [ProdukController::class, 'destroy'])->name('produk.destroy');

    Route::get('/seller/profil', [SellerProfileController::class, 'edit'])->name('profile.seller');
    Route::patch('/seller/profil', [SellerProfileController::class, 'update'])->name('update.seller');
    Route::delete('/seller/profile', [SellerProfileController::class, 'destroy'])->name('destroy.seller');
    Route::patch('/seller/profile', [SellerProfileController::class, 'updateWhatsapp'])->name('seller.whatsapp.update');
    Route::patch('/seller/profile/details', [SellerProfileController::class, 'updateDetails'])->name('seller.profile.details');
    Route::patch('/seller/profile/photo', [SellerProfileController::class, 'updatePhoto'])->name('seller.profile.photo');
    Route::post('/seller/profile/portfolio', [SellerProfileController::class, 'addPortfolio'])->name('seller.portfolio.add');
    Route::delete('/seller/profile/portfolio/{index}', [SellerProfileController::class, 'deletePortfolio'])->name('seller.portfolio.delete');
});

// ─── Routes untuk Admin ──────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/seller', [AdminController::class, 'seller'])->name('admin.seller');
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');
    Route::patch('/admin/seller/{sellerProfile}/setujui', [AdminController::class, 'setujuiSeller'])->name('admin.seller.setujui');
    Route::patch('/admin/seller/{sellerProfile}/tolak', [AdminController::class, 'tolakSeller'])->name('admin.seller.tolak');
    Route::delete('/admin/seller/{sellerProfile}', [AdminController::class, 'destroySeller'])->name('admin.seller.destroy');
    Route::patch('/admin/produk/{produk}/setujui', [AdminController::class, 'setujuiProduk'])->name('admin.produk.setujui');
    Route::patch('/admin/produk/{produk}/tolak', [AdminController::class, 'tolakProduk'])->name('admin.produk.tolak');
    Route::delete('/admin/produk/{produk}', [AdminController::class, 'destroyProduk'])->name('admin.produk.destroy');
    Route::get('/admin/kategori', [AdminController::class, 'kategori'])->name('admin.kategori');
    Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
    Route::put('/admin/kategori/{category}', [AdminController::class, 'updateKategori'])->name('admin.kategori.update');
    Route::patch('/admin/kategori/{category}/toggle', [AdminController::class, 'toggleKategori'])->name('admin.kategori.toggle');
    Route::delete('/admin/kategori/{category}', [AdminController::class, 'destroyKategori'])->name('admin.kategori.destroy');
});

// ─── Routes umum (auth tanpa role tertentu) ──────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
