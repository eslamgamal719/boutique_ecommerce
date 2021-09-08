<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\LoginController;
use App\Http\Controllers\Backend\CategoriesController;
use App\Http\Controllers\Backend\ProductController;
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
    
    Route::middleware('admin')->group(function () {
        Route::get('/index', [DashboardController::class, 'index'])->name('index');

        Route::resource('categories', CategoriesController::class);
        Route::resource('products', ProductController::class);
        Route::resource('tags', TagController::class);
    });
});