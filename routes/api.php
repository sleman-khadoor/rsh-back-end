<?php

use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Main\AuthorController as MainAuthorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BookCategoryController as AdminBookCategoryController;
use App\Http\Controllers\Main\BookCategoryController as MainBookCategoryController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});


Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Route::apiResource('/book-categories', AdminBookCategoryController::class)->middleware("role:". Role::getBooksAdminRole());
    Route::apiResource('/authors', AdminAuthorController::class)->middleware("role:". Role::getBooksAdminRole());
});


Route::get('/book-categories', MainBookCategoryController::class);
Route::get('/authors', [MainAuthorController::class, 'index']);
Route::get('/authors/{author}', [MainAuthorController::class, 'show']);
