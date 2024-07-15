<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthorController;
use App\Http\Controllers\Admin\BookAwardController;
use App\Http\Controllers\Admin\BookCategoryController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\BookReviewController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactRequestController;
use App\Http\Controllers\Admin\ContactTypeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\RepresentedAuthorController;
use App\Http\Controllers\Admin\ServiceRequestController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\UserManagemenrController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ResetPasswordController;
use App\Models\Role;




Route::prefix('admin')->middleware(['auth:sanctum'])->group(function() {

    Route::middleware(["role:". Role::getBooksAdminRole()])->group(function() {

        Route::apiResource('/books', BookController::class);
        Route::apiResource('/book-categories', BookCategoryController::class);
        Route::apiResource('/authors', AuthorController::class);
        Route::apiResource('/book-awards', BookAwardController::class)->only(['store', 'update', 'destroy']);
        Route::apiResource('/book-reviews', BookReviewController::class)->only(['store', 'update', 'destroy']);

        Route::apiResource('/contact-types', ContactTypeController::class);
        Route::apiResource('/contacts', ContactController::class);

        Route::get('/notifications', [NotificationController::class, 'index']);
        Route::get('/notifications/{type}', [NotificationController::class, 'getByType']);


        Route::apiResource('/blogs', BlogController::class);
        Route::apiResource('/blog-categories', BlogCategoryController::class);


        Route::apiResource('/contact-requests', ContactRequestController::class)->only(['index', 'show', 'destroy']);
        Route::apiResource('/service-requests', ServiceRequestController::class)->only(['index', 'show', 'destroy']);

        Route::apiResource('/represented-authors', RepresentedAuthorController::class);

        Route::apiResource('/partners', PartnerController::class);

        Route::apiResource('/users', UserManagemenrController::class);
        Route::apiResource('/achievements', AchievementController::class);

        Route::post('/reset-password', ResetPasswordController::class);
    });
});
