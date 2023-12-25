<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// routes api/v1/{{route}}
Route::group(['prefix' => 'v1'], function () {
    Route::get('products', [App\Http\Controllers\API\ProductController::class, 'index']);
    Route::get('categories', [App\Http\Controllers\API\ProductController::class, 'category']);

    Route::post('register', [App\Http\Controllers\API\AuthController::class, 'register']);
    Route::post('login', [App\Http\Controllers\API\AuthController::class, 'login']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('logout', [App\Http\Controllers\API\AuthController::class, 'logout']);
        Route::get('user', [App\Http\Controllers\API\AuthController::class, 'profile']);
        Route::post('user', [App\Http\Controllers\API\AuthController::class, 'updateProfile']);
    });

});
