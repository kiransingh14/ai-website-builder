<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', fn() => view('auth.register'));

Route::middleware(['web', 'auth'])->group(function () {
    // Route::get('/dashboard', [BusinessController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [BusinessController::class, 'index']);
});