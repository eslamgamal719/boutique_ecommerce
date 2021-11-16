<?php

use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\CustomerController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\Frontend\ProductController;
use App\Http\Controllers\Frontend\ShopController;
use App\Http\Controllers\Frontend\WishlistController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::as('frontend.')->group(function () {
    Route::get('/',                 [FrontendController::class, 'index'])->name('index');
    Route::get('/shop/{slug?}',     [ShopController::class, 'shop'])->name('shop');
    Route::get('/shop/tags/{slug}', [ShopController::class, 'shop_tag'])->name('shop.tag');
    Route::get('/product/{slug?}',  [ProductController::class, 'product'])->name('product');
    Route::get('/cart',             [CartController::class, 'cart'])->name('cart');
    Route::get('/wishlist',         [WishlistController::class, 'wishlist'])->name('wishlist');

});

Route::as('frontend.')->middleware('auth:web')->group(function () {
    Route::get('profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::patch('profile', [CustomerController::class, 'update_profile'])->name('customer.update_profile');
    Route::get('profile/remove-profile', [CustomerController::class, 'remove_profile_image'])->name('customer.remove_profile_image');
    Route::get('addresses', [CustomerController::class, 'addresses'])->name('customer.addresses');
    Route::get('dashboard', [CustomerController::class, 'dashboard'])->name('customer.dashboard');
    Route::get('orders', [CustomerController::class, 'orders'])->name('customer.orders');
    

    Route::middleware('check_cart')->group(function() {
        Route::get('/checkout',            [PaymentController::class, 'checkout'])->name('checkout');
        Route::post('/checkout/payment',   [PaymentController::class, 'checkout_now'])->name('checkout.payment');
       
        Route::get('/checkout/{order_id}/cancelled',   [PaymentController::class, 'cancelled'])->name('checkout.cancel');
        Route::get('/checkout/{order_id}/completed',   [PaymentController::class, 'completed'])->name('checkout.complete');
        Route::get('/checkout/webhook/{order_id?}/{env?}',   [PaymentController::class, 'webhook'])->name('checkout.webhook.ipn');
    });

});


Auth::routes(['verify' => true]);

Route::get('/home',  [App\Http\Controllers\HomeController::class, 'index'])->name('home');
