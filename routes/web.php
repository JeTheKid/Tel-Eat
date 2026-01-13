<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\KatalogController;

/*
AREA PUBLIK (Bisa diakses tanpa login)
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Katalog
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog');

//Login & Register
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

/*
| AREA HARUS LOGIN (Admin & Mahasiswa)
*/
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::any('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Mahasiswa
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/hapus-foto', [ProfileController::class, 'deletePhoto'])->name('profile.delete_photo');

    // Route Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
    Route::patch('/cart/change-qty', [CartController::class, 'changeQuantity'])->name('cart.change_qty');
    Route::patch('/update-cart', [CartController::class, 'update'])->name('update_cart');
    Route::delete('/remove-from-cart', [CartController::class, 'remove'])->name('remove_from_cart');

    // Route Checkout
    Route::get('/checkout', [CartController::class, 'checkoutPage'])->name('checkout.page');
    Route::post('/checkout', [CartController::class, 'processCheckout'])->name('checkout.process');

    // Route History
    Route::get('/riwayat', [HistoryController::class, 'index'])->name('riwayat');

    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // CRUD Produk
    Route::resource('products', ProductController::class);

    // Order admin
    Route::get('/admin/orders', [OrderController::class, 'index'])->name('admin.orders.index');
    Route::put('/admin/orders/{id}', [OrderController::class, 'updateStatus'])->name('admin.orders.update');

    // Route Pengaturan Toko
    Route::resource('/admin/settings', SettingController::class)->names('settings');

});

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

// Route Pengganti Storage (Karena hosting memblokir kata 'storage')
Route::get('/gambar/{path}', function ($path) {
    // Cari file di gudang asli (storage/app/public)
    $path = storage_path('app/public/' . $path);

    if (!File::exists($path)) {
        abort(404);
    }

    $file = File::get($path);
    $type = File::mimeType($path);

    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);

    return $response;
})->where('path', '.*');
