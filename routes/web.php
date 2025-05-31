<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\CustomerLoginController;
use App\Http\Controllers\Auth\CustomerRegisterController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminRegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
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
| Landing Page
|--------------------------------------------------------------------------
*/
Route::get('/', fn () => view('welcome'))->name('welcome');

/*
|--------------------------------------------------------------------------
| Customer Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('customer')->group(function () {
    Route::get('/login', [CustomerLoginController::class, 'showLoginForm'])->name('customer.login.form');
    Route::post('/login', [CustomerLoginController::class, 'login'])->name('customer.login');
    Route::post('/logout', [CustomerLoginController::class, 'logout'])->name('customer.logout');

    Route::get('/register', [CustomerRegisterController::class, 'showRegisterForm'])->name('customer.register.form');
    Route::post('/register', [CustomerRegisterController::class, 'register'])->name('customer.register');

    // Forgot password
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('customer.password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('customer.password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('customer.password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('customer.password.update');
});

/*
|--------------------------------------------------------------------------
| Customer Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:customer')->prefix('customer')->name('customer.')->group(function () {

    // Dashboard
    Route::get('/home', [CustomerController::class, 'home'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Produk
    |--------------------------------------------------------------------------
    */
    Route::get('/products', [CustomerProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [CustomerProductController::class, 'show'])->name('products.show');
    Route::post('/products/{product}/buy-now', [CustomerProductController::class, 'buyNow'])->name('products.buyNow');

    /*
    |--------------------------------------------------------------------------
    | Keranjang (Cart)
    |--------------------------------------------------------------------------
    */
    Route::get('/cart', [CustomerController::class, 'cart'])->name('cart');
    Route::post('/products/{product}/add-to-cart', [CartController::class, 'add'])->name('products.addToCart');
    Route::delete('/cart/{id}', [CartController::class, 'delete'])->name('cart.delete');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear/buynow', [CartController::class, 'clearBuyNow'])->name('cart.clearBuyNow');

    /*
    |--------------------------------------------------------------------------
    | Checkout Flow
    |--------------------------------------------------------------------------
    */
    Route::get('/checkout/{id}', [CheckoutController::class, 'detail'])->name('checkout.detail');             // Step 1: Detail transaksi
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');                  // Step 2: Simpan transaksi
    Route::get('/checkout/confirm/{id}', [CheckoutController::class, 'confirm'])->name('checkout.confirm');  // Step 3: Halaman konfirmasi pembayaran
    Route::post('/checkout/upload', [CheckoutController::class, 'submitConfirmation'])->name('checkout.upload'); // Step 4: Upload bukti transfer

    /*
    |--------------------------------------------------------------------------
    | Transaksi
    |--------------------------------------------------------------------------
    */
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
    Route::get('/history', [TransactionController::class, 'history'])->name('history');

    /*
    |--------------------------------------------------------------------------
    | Pembayaran Manual
    |--------------------------------------------------------------------------
    */
    Route::get('/payment/confirmation/{transaction}', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/payment/confirmation/{transaction}', [PaymentController::class, 'store'])->name('payment.store');

    /*
    |--------------------------------------------------------------------------
    | Invoice
    |--------------------------------------------------------------------------
    */
    Route::get('/invoice/{transaction}', [TransactionController::class, 'generateInvoice'])->name('invoice');
});

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

    Route::get('/register', [AdminRegisterController::class, 'showRegisterForm'])->name('admin.register.form');
    Route::post('/register', [AdminRegisterController::class, 'register'])->name('admin.register');
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home', fn () => view('admin.home'))->name('home');

    // Users
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

    // Produk
    Route::resource('products', ProductController::class)->parameters(['products' => 'product']);

    // Transaksi
    Route::get('/transactions', [AdminTransactionController::class, 'index'])->name('transactions.index');
    Route::patch('/transactions/{id}/verify', [AdminTransactionController::class, 'verify'])->name('transactions.verify');
    Route::patch('/transactions/{id}/reject', [AdminTransactionController::class, 'reject'])->name('transactions.reject');
    Route::get('/transactions/{id}/delivery-order', [AdminTransactionController::class, 'previewDeliveryOrder'])->name('transactions.delivery-order');
    Route::get('/transactions/{id}/delivery-order/download', [AdminTransactionController::class, 'downloadDeliveryOrder'])->name('transactions.delivery-order.download');
});

/*
|--------------------------------------------------------------------------
| Debug & Fallback
|--------------------------------------------------------------------------
*/
Route::middleware('auth:admin')->get('/cek-produk', fn () => \App\Models\Product::all())->name('cek.produk');
Route::fallback(fn () => response()->view('errors.404', [], 404));

/*
|--------------------------------------------------------------------------
| Default Laravel Auth & Home (optional if not used)
|--------------------------------------------------------------------------
*/
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
