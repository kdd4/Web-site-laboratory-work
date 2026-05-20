<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\BlogCommentController;
use App\Http\Middleware\RequireAuth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(RequireAuth::class)->group(function() {
    Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
    Route::get('/blog/image/{id}', [BlogController::class, 'image'])->name('blog.image');

    Route::post('/blog', [BlogController::class, 'create'])->name('auth.blog.create');
    Route::patch('/blog', [BlogController::class, 'edit'])->name('admin.blog.edit');
    Route::post('/blog/file', [BlogController::class, 'loadFromFile'])->name('admin.blog.loadfile');


    Route::get('/blog/comments/{id}', [BlogCommentController::class, 'index'])->name('auth.blog.comment.index');
    Route::post('/blog/comment', [BlogCommentController::class, 'create'])->name('auth.blog.comment.create');
});