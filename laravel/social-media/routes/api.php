<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::middleware('auth:sanctum')->group(function () {
Route::get('/posts', [PostController::class, 'index']);


Route::put('/posts/{post}', [PostController::class, 'update']);
Route::delete('/posts/{post}', [PostController::class, 'destroy']);
Route::delete('/posts/{post}/comments/{comment}', [PostController::class, 'deleteComment']);

Route::post('/posts', [PostController::class, 'store']);
Route::post('/posts/{post}/like', [PostController::class, 'toggleLike']);
Route::post('/posts/{post}/comments', [PostController::class, 'addComment']);
});