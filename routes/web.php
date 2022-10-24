<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\NotificationsController;


Route::get('/', [PostController::class, 'index'])->name('index');
Route::get('/trending', [PostController::class, 'trending'])->name('trending');
Route::get('@{user:username}', [UserController::class, 'show'])->name('user-profile');
Route::get('@{user:username}/follows', [UserController::class, 'follows'])->name('user-profile-follows');
Route::get('@{user:username}/followers', [UserController::class, 'followers'])->name('user-profile-followers');
Route::get('/community', [UserController::class, 'index'])->name('community');

Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])->group(function () {
    Route::get('/notifications', [NotificationsController::class, 'index'])->name('notifications');
    Route::post('/p/{post}/upvote', [PostController::class, 'upvote'])->name('upvote');
    Route::post('/p/{post}/downvote', [PostController::class, 'downvote'])->name('downvote');
    Route::post('/r/{reply}/upvote', [ReplyController::class, 'upvote'])->name('reply-upvote');
    Route::post('/r/{reply}/downvote', [ReplyController::class, 'downvote'])->name('reply-downvote');
    Route::post('/p/{post}/reply', [ReplyController::class, 'store'])->name('reply');
    Route::delete('/r/{reply}/delete', [ReplyController::class, 'destroy'])->name('reply.destroy');
    Route::post('/{user:username}/follow', [UserController::class, 'follow'])->name('follow');
    Route::post('upload', [PostController::class, 'store'])->name('post.store');
    Route::delete('/{post}/delete', [PostController::class, 'destroy'])->name('post.destroy');
    Route::group(['middleware' => 'admin'], function () {
    });
});

Route::get('/c/{category:slug}', [CategoryController::class, 'show'])->name('category');
Route::get('/p/{post}', [PostController::class, 'show'])->name('post.show');