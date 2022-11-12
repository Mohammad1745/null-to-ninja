<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('/post')->as('post.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index'); //post.index
    Route::get('/create', [PostController::class, 'create'])->name('create');//post.create
    Route::post('/', [PostController::class, 'store'])->name('store');
    Route::get('/{id}', [PostController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('edit');
    Route::patch('/update', [PostController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [PostController::class, 'destroy'])->name('delete');
});
Route::middleware(['auth', 'verified'])->prefix('/post')->as('post.')->group(function () {
    Route::get('/{id}/like', [PostController::class, 'like'])->name('like');
    Route::get('/{id}/dislike', [PostController::class, 'dislike'])->name('dislike');
    Route::post('/{id}/comment', [PostController::class, 'comment'])->name('comment');
});
