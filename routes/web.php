<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog-posts', [\App\Http\Controllers\BlogPostController::class, 'index'])->name('blog-posts.index');
Route::get('/blog-posts/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'edit'])->name('blog-posts.edit');
Route::put('/blog-posts/{blogPost}', [\App\Http\Controllers\BlogPostController::class, 'update']);
