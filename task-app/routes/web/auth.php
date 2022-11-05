<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

//Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'processLogin'])->name('login.process');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'processRegistration'])->name('register.process');
Route::get('/verification', [AuthController::class, 'verification'])->name('verification');
Route::post('/verification', [AuthController::class, 'processVerification'])->name('verification.process');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
