<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->prefix('/task')->as('task.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index'); //task.index
    Route::get('/create', [TaskController::class, 'create'])->name('create');//task.create
    Route::post('/', [TaskController::class, 'store'])->name('store');
    Route::get('/{id}', [TaskController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [TaskController::class, 'edit'])->name('edit');
    Route::patch('/update', [TaskController::class, 'update'])->name('update');
    Route::get('/{id}/delete', [TaskController::class, 'destroy'])->name('delete');
});
