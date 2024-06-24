<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\Book\BookCategoryController as AdminBookCategoryController;
use App\Http\Controllers\Public\Book\BookCategoryController as PublicBookCategoryController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});


Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Route::apiResource('/book-categories', AdminBookCategoryController::class)->middleware("role:". Role::getBooksAdminRole());
});


Route::get('/book-categories', PublicBookCategoryController::class);
