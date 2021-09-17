<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\TagController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function() {
    return view('backend.login');
});

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('admin_guest');
    Route::post('/login', [LoginController::class, 'auth_login'])->name('auth.login');
    Route::get('/forgot-password', [LoginController::class, 'forgot_password'])->name('forgot.password')->middleware('admin_guest');
    
    Route::middleware('auth:admin')->group(function () {
        Route::get('/index', [DashboardController::class, 'index'])->name('index');
        
        Route::post('categories/remove-image', [CategoriesController::class, 'remove_image'])->name('categories.remove_image');
        Route::resource('categories', CategoriesController::class);

        Route::post('products/remove-image', [ProductController::class, 'remove_image'])->name('products.remove_image');
        Route::resource('products', ProductController::class);

        Route::resource('tags', TagController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('reviews', ReviewController::class);

        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::resource('customers', CustomerController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

    });
});
