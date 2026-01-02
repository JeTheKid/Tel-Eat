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

/*
AREA PUBLIK (Bisa diakses tanpa login)
*/

// Landing Page
Route::get('/', [LandingController::class, 'index'])->name('landing');

// Katalog
Route::get('/katalog', function (\Illuminate\Http\Request $request) {
    // filter kategori
    $query = App\Models\Product::with('category')->latest();
    if ($request->has('kategori')) {
        $query->whereHas('category', function ($q) use ($request) {
            $q->where('nama_kategori', $request->kategori);
        });
    }
    $products = $query->get();
    $categories = App\Models\Category::all();
    return view('katalog', compact('products', 'categories'));
})->name('katalog');

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
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Profile Mahasiswa
    Route::get('/profil', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profil', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profil/hapus-foto', [ProfileController::class, 'deletePhoto'])->name('profile.delete_photo');

    // Route Keranjang
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add-to-cart/{id}', [CartController::class, 'addToCart'])->name('add_to_cart');
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
    Route::get('/admin/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [SettingController::class, 'update'])->name('admin.settings.update');
    Route::delete('/admin/settings', [SettingController::class, 'deleteQris'])->name('admin.settings.delete_qris');

});
