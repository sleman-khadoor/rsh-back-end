<?php

use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\BookAwardController as AdminBookAwardController;
use App\Http\Controllers\Main\AuthorController as MainAuthorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BookCategoryController as AdminBookCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BookReviewController as AdminBookReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ContactTypeController as AdminContactTypeController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Main\BookController as PublicBookController;
use App\Http\Controllers\Main\BookCategoryController as MainBookCategoryController;
use App\Http\Controllers\Main\ContactController as PublicContactController;
use App\Http\Controllers\Main\ContactRequestController as PublicContactRequestController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function() {
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum')->name('auth.logout');
});


Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Route::middleware(["role:". Role::getBooksAdminRole()])->group(function() {

        Route::apiResource('/books', AdminBookController::class);
        Route::apiResource('/book-categories', AdminBookCategoryController::class);
        Route::apiResource('/authors', AdminAuthorController::class);
        Route::apiResource('/book-awards', AdminBookAwardController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/book-reviews', AdminBookReviewController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('/contact-types', AdminContactTypeController::class);
        Route::apiResource('/contacts', AdminContactController::class);

        Route::get('/notifications', [AdminNotificationController::class, 'index']);
        Route::get('/notifications/{type}', [AdminNotificationController::class, 'getByType']);
    });
});

// Books endpoints
Route::get('/books', [PublicBookController::class, 'index']);
Route::get('/books/{book}', [PublicBookController::class, 'show']);
Route::get('/book-categories', MainBookCategoryController::class);

// Authors endpoints
Route::get('/authors', [MainAuthorController::class, 'index']);
Route::get('/authors/{author}', [MainAuthorController::class, 'show']);

Route::get('/contacts', PublicContactController::class);

Route::post('/contact-requests', PublicContactRequestController::class);//->middleware('throttle:2,60');
