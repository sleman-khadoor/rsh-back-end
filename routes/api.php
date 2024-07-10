<?php

use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\BookAwardController as AdminBookAwardController;
use App\Http\Controllers\Main\AuthorController as MainAuthorController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\BookCategoryController as AdminBookCategoryController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BookReviewController as AdminBookReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ContactRequestController as AdminContactRequestController;
use App\Http\Controllers\Admin\ContactTypeController as AdminContactTypeController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Main\BookController as MainBookController;
use App\Http\Controllers\Main\BlogController as MainBlogController;
use App\Http\Controllers\Main\BookCategoryController as MainBookCategoryController;
use App\Http\Controllers\Main\BlogCategoryController as MainBlogCategoryController;
use App\Http\Controllers\Main\ContactController as MainContactController;
use App\Http\Controllers\Main\ContactRequestController as MainContactRequestController;
use App\Http\Controllers\Admin\RepresentedAuthorController as AdminRepresentedAuthorController;
use App\Http\Controllers\Main\RepresentedAuthorController as MainRepresentedAuthorController;
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


        Route::apiResource('/blogs', AdminBlogController::class);
        Route::apiResource('/blog-categories', AdminBlogCategoryController::class);

        Route::apiResource('/contact-requests', AdminContactRequestController::class)->only(['index', 'show', 'destroy']);
        Route::apiResource('/represented-authors', AdminRepresentedAuthorController::class);
    });
});

// Books endpoints
Route::get('/books', [MainBookController::class, 'index']);
Route::get('/books/{book}', [MainBookController::class, 'show']);
Route::get('/book-categories', MainBookCategoryController::class);

// Authors endpoints
Route::get('/authors', [MainAuthorController::class, 'index']);
Route::get('/authors/{author}', [MainAuthorController::class, 'show']);

// Blogs endpoints
Route::get('/blogs', [MainBlogController::class, 'index']);
Route::get('/blogs/{blog}', [MainBlogController::class, 'show']);
Route::get('/blog-categories', MainBlogCategoryController::class);

Route::get('/contacts', MainContactController::class);
Route::post('/contact-requests', MainContactRequestController::class)->middleware('throttle:2,60');

// Represented Authors endpoints
Route::get('/represented-authors', [MainRepresentedAuthorController::class, 'index']);
Route::get('/represented-authors/{author}', [MainRepresentedAuthorController::class, 'show']);
