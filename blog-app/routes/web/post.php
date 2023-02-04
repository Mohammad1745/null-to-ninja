<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('/post')->as('post.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index'); //loading initial the page

    Route::get('/list', [PostController::class, 'getList'])->name('list');
    Route::get('/{id}', [PostController::class, 'getSingle'])->name('single');
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::post('/update', [PostController::class, 'update'])->name('update');
    Route::get('/delete/{id}', [PostController::class, 'destroy'])->name('delete');
});




Route::middleware(['auth', 'verified'])->prefix('/post')->as('post.')->group(function () {
    Route::get('/{id}/like', [PostController::class, 'like'])->name('like');
    Route::get('/{id}/dislike', [PostController::class, 'dislike'])->name('dislike');
    Route::post('/{id}/comment', [PostController::class, 'comment'])->name('comment');
});
