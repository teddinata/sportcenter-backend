<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductGalleryController;
use App\Http\Controllers\ProductSizeController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // prefix: dashhboard
    Route::prefix('dashboard')->group(function () {
        // name: dashboard


        Route::middleware(['admin'])->group(function (){
            Route::name('dashboard')->group(function () {
                // get: dashboard
                Route::get('/', function () {
                    return view('dashboard');
                });
            });
            // prefix: product-categories
            Route::resource('category', ProductCategoryController::class);
            // prefix: products
            Route::resource('product', ProductController::class);
            Route::resource('product-gallery', ProductGalleryController::class);
            // user
            Route::resource('user', UserController::class);
            Route::resource('size', SizeController::class);
            Route::resource('product_size', ProductSizeController::class);
        });
    });
});
