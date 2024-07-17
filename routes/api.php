<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;


Route::post('register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout']);
Route::post('refresh', [AuthController::class, 'refresh']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('products/{id}', [ProductController::class, 'show']);
    Route::get('products', [ProductController::class, 'index']);
    Route::get('me', [AuthController::class, 'me']);
});
