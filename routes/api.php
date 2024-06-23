<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Book\BookCategoryController;
use App\Http\Controllers\Public\Book\BookCategoryController as BookBookCategoryController;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});


Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Route::apiResource('/book-categories', BookCategoryController::class);
});


Route::get('/book-categories', BookBookCategoryController::class);
