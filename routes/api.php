<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('posts/my', [PostController::class, 'getCurrentUsersPosts']);
    Route::get('posts/recents', [PostController::class, 'getRecentsUsersWithPosts']);

    Route::apiResource('posts', PostController::class);
    Route::post('posts/moderator/{post}/block', [PostController::class, 'block']);

});


