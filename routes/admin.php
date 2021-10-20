<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\CityController;
use App\Http\Controllers\Backend\CountryController;
use App\Http\Controllers\Backend\CouponController;
use App\Http\Controllers\Backend\CustomerController;
use App\Http\Controllers\Backend\CustomerAddressController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\ReviewController;
use App\Http\Controllers\Backend\ShippingCompanyController;
use App\Http\Controllers\Backend\StateController;
use App\Http\Controllers\Backend\SupervisorController;
use App\Http\Controllers\Backend\TagController;
use App\Http\Controllers\Backend\PaymentController;
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
        Route::get('/account_settings', [DashboardController::class, 'account_settings'])->name('account.settings');
        Route::post('/admin/remove_image', [DashboardController::class, 'remove_image'])->name('remove_image');
        Route::patch('/account_settings/{id}', [DashboardController::class, 'update_account_settings'])->name('update.account.settings');
        
        Route::post('categories/remove-image', [CategoriesController::class, 'remove_image'])->name('categories.remove_image');
        Route::resource('categories', CategoriesController::class);

        Route::post('products/remove-image', [ProductController::class, 'remove_image'])->name('products.remove_image');
        Route::resource('products', ProductController::class);

        Route::resource('tags', TagController::class);
        Route::resource('coupons', CouponController::class);
        Route::resource('reviews', ReviewController::class);

        Route::post('customers/remove-image', [CustomerController::class, 'remove_image'])->name('customers.remove_image');
        Route::get('customers/get_customers', [CustomerController::class, 'get_customers'])->name('customers.get_customers');
        Route::resource('customers', CustomerController::class);
        Route::resource('customer_addresses', CustomerAddressController::class);

        Route::post('supervisors/remove-image', [SupervisorController::class, 'remove_image'])->name('supervisors.remove_image');
        Route::resource('supervisors', SupervisorController::class);

        Route::resource('countries', CountryController::class);

        Route::get('states/get_states', [StateController::class, 'get_states'])->name('states.get_states');
        Route::resource('states', StateController::class);

        Route::get('cities/get_cities', [CityController::class, 'get_cities'])->name('cities.get_cities');
        Route::resource('cities', CityController::class);

        Route::resource('shipping_companies', ShippingCompanyController::class);

        Route::resource('payments', PaymentController::class);

    });
});
