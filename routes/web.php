<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\Customer\ProductController as CustomerProductController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\TransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Customer\PaymentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Ini adalah definisi semua rute utama yang digunakan oleh aplikasi
| pemesanan barang di CV Mandiri Dwi Putra.
*/

/* ======================= LANDING PAGE ======================= */
Route::get('/', fn () => view('welcome'))->name('welcome');

/* ===================== CUSTOMER AUTH ===================== */
Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login.form');
    Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.login');
    Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

    Route::get('/register', [CustomerRegisterController::class, 'showRegisterForm'])->name('customer.register.form');
    Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.register');
});

/* ========== CUSTOMER PROTECTED ROUTES ========== */
Route::middleware('auth:customer')->prefix('customer')->name('customer.')->group(function () {
    Route::get('/home', [CustomerController::class, 'home'])->name('home');

    // Produk
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');

    // Keranjang
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::post('/products/{product}/add-to-cart', [CartController::class, 'add'])->name('products.addToCart');
    Route::post('/products/{product}/buy', [CartController::class, 'buyNow'])->name('products.buyNow');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear/buynow', [CartController::class, 'clearBuyNow'])->name('cart.clearBuyNow');

    // Checkout
    Route::get('/checkout/detail', [CheckoutController::class, 'detail'])->name('checkout.detail');
    Route::post('/checkout/confirm', [CheckoutController::class, 'confirm'])->name('checkout.confirm');
    Route::post('/checkout/submit', [CheckoutController::class, 'submitConfirmation'])->name('checkout.submit');
    Route::post('/checkout/upload', [CheckoutController::class, 'submitConfirmation'])->name('checkout.upload');

    // Transaksi
    Route::post('/transactions', [TransactionController::class, 'store'])->name('transactions.store');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/history', [TransactionController::class, 'history'])->name('history');

    // Pembayaran
    Route::get('/payment/confirmation/{transaction}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/confirmation/{transaction}', [PaymentController::class, 'store'])->name('payment.store');

    // Invoice
    Route::get('/invoice/{transaction}', [TransactionController::class, 'generateInvoice'])->name('invoice');
});

/* ======================= ADMIN AUTH ======================= */
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('admin.register.form');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('admin.register');
});

/* ========== ADMIN PROTECTED ROUTES ========== */
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', fn () => view('admin.home'))->name('home');

    // User
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

    // Produk
    Route::resource('products', ProductController::class)->parameters(['products' => 'product']);

    // Transaksi
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{id}/verify', [AdminTransactionController::class, 'verify'])->name('transactions.verify');
    Route::patch('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');

    // Delivery Order (PDF Preview & Download)
    Route::get('/transactions/{id}/delivery-order', [AdminTransactionController::class, 'previewDeliveryOrder'])->name('transactions.delivery-order');
    Route::get('/transactions/{id}/delivery-order/download', [AdminTransactionController::class, 'downloadDeliveryOrder'])->name('transactions.delivery-order.download');
});

/* ======================== DEBUG & FALLBACK ======================== */

// Testing admin access
Route::middleware('auth:admin')->get('/cek-produk', fn () => \App\Models\Product::all())->name('cek.produk');

// 404 fallback
Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
