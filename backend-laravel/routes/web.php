<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/blog', [BlogController::class, 'index']);
Route::get('/blog/image/{id}', [BlogController::class, 'image']);

Route::post('/blog', [BlogController::class, 'create']);
Route::put('/blog', [BlogController::class, 'edit']);
Route::post('/blog/file', [BlogController::class, 'loadFromFile']);


Route::get('/blog/comments/{id}', [BlogCommentController::class, 'index']);
Route::post('/blog/comment', [BlogCommentController::class, 'create']);