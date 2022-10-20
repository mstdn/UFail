<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::get('/', [PostController::class, 'index'])->name('index');
// Route::get('/categories', [CategoryController::class, 'index'])->name('categories');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::post('/{post}/upvote', [PostController::class, 'upvote'])->name('upvote');
    Route::post('/{post}/downvote', [PostController::class, 'downvote'])->name('downvote');

    Route::group(['middleware' => 'admin'], function () {
       Route::post('upload', [PostController::class, 'store'])->name('post.store');
    });
});

Route::get('/c/{category:slug}', [CategoryController::class, 'show'])->name('category');