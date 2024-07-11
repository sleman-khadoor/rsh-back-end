<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\BookAwardController as AdminBookAwardController;
use App\Http\Controllers\Admin\BookCategoryController as AdminBookCategoryController;
use App\Http\Controllers\Admin\BlogCategoryController as AdminBlogCategoryController;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BookReviewController as AdminBookReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ContactRequestController as AdminContactRequestController;
use App\Http\Controllers\Admin\ContactTypeController as AdminContactTypeController;
use App\Http\Controllers\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Admin\RepresentedAuthorController as AdminRepresentedAuthorController;
use App\Http\Controllers\Admin\ServiceRequestController as AdminServiceRequestController;
use App\Http\Controllers\Admin\PartnerController as AdminPartnerController;
use App\Models\Role;




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
        Route::apiResource('/service-requests', AdminServiceRequestController::class)->only(['index', 'show', 'destroy']);

        Route::apiResource('/represented-authors', AdminRepresentedAuthorController::class);

        Route::apiResource('/partners', AdminPartnerController::class);
    });
});
