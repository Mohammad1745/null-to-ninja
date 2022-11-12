<?php

use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->prefix('/comment')->as('comment.')->group(function () {
    Route::get('/{id}/like', [CommentController::class, 'like'])->name('like');
    Route::get('/{id}/dislike', [CommentController::class, 'dislike'])->name('dislike');
    Route::post('/{id}/comment', [CommentController::class, 'comment'])->name('comment');
});
