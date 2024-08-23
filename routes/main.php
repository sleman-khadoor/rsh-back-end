<?php

use App\Http\Controllers\Main\AuthorController as MainAuthorController;

use App\Http\Controllers\Main\BookController as MainBookController;
use App\Http\Controllers\Main\BlogController as MainBlogController;
use App\Http\Controllers\Main\BookCategoryController as MainBookCategoryController;
use App\Http\Controllers\Main\BlogCategoryController as MainBlogCategoryController;
use App\Http\Controllers\Main\ContactController as MainContactController;
use App\Http\Controllers\Main\ContactRequestController as MainContactRequestController;

use App\Http\Controllers\Main\RepresentedAuthorController as MainRepresentedAuthorController;
use App\Http\Controllers\Main\ServiceRequestController as MainServiceRequestController;

use App\Http\Controllers\Main\PartnerController as MainParterController;

use App\Http\Controllers\Main\AchievementController as MainAchievementController;
use App\Http\Controllers\Main\NewsController as MainNewsController;
use Illuminate\Support\Facades\Route;


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
Route::post('/contact-requests', MainContactRequestController::class);

// Represented Authors endpoints
Route::get('/represented-authors', [MainRepresentedAuthorController::class, 'index']);
Route::get('/represented-authors/{author}', [MainRepresentedAuthorController::class, 'show']);

// Service Requests endpoints
Route::post('/service-requests', MainServiceRequestController::class);

// Partners endpoints
Route::get('/partners', [MainParterController::class, 'index']);
Route::get('/partners/{partner}', [MainParterController::class, 'show']);

// Achievements endpoints
Route::get('/achievements', [MainAchievementController::class, 'index']);
Route::get('/achievements/{achievement}', [MainAchievementController::class, 'show']);

//News endpoints
Route::get('/news', [MainNewsController::class, 'index']);
Route::get('/news/{news}', [MainNewsController::class, 'show']);
