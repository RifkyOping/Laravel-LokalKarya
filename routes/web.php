<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\ProdukController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $role = Auth::user()->role;

    if ($role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($role === 'seller') {
        return redirect()->route('seller.dashboard');
    }
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/seller/dashboard', [SellerController::class, 'index'])->name('seller.dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/seller/produk', [ProdukController::class, 'index'])->name('produk.seller');
    Route::get('/seller/produk/create', [ProdukController::class, 'create'])->name('seller.create');
    Route::post('/seller/produk', [ProdukController::class, 'store'])->name('seller.store');
    Route::get('/seller/produk/{produk}/edit', [ProdukController::class, 'edit'])->name('seller.edit');
    Route::put('/seller/produk/{produk}', [ProdukController::class, 'update'])->name('seller.update');

    Route::get('/seller/profil', [SellerProfileController::class, 'edit'])->name('profile.seller');
    Route::patch('/seller/profil', [SellerProfileController::class, 'update'])->name('update.seller');
    Route::delete('/seller/profile', [SellerProfileController::class, 'destroy'])->name('destroy.seller');

    Route::get('/seller/create', [SellerController::class, 'create'])->name('seller.create');
    Route::post('/seller/create', [SellerController::class, 'store'])->name('seller.store');

    Route::get('/admin/seller', [AdminController::class, 'seller'])->name('admin.seller');
    Route::get('/admin/produk', [AdminController::class, 'produk'])->name('admin.produk');

});

Route::get('/seller/show', [SellerController::class, 'show'])->name('seller.show');

require __DIR__.'/auth.php';
