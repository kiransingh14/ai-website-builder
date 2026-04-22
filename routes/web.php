<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect('/login'));

Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', fn() => view('auth.register'))->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::middleware(['web', 'auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/dashboard', [BusinessController::class, 'index']);
    Route::post('/addBusinessDetails', [BusinessController::class, 'createBusiness']);
    Route::get('/addBusinessDetails',fn() => view('website.add-business'))->name('add-business');
    Route::get('/website/{id}', [BusinessController::class, 'getWebsite']);
    Route::get('/website/download/{id}', [BusinessController::class, 'downloadWebContent']);
    Route::get('/business/delete/{id}', [BusinessController::class, 'deleteBusiness']);
});

Route::fallback(function (Request $request) {
    return response()->json([
        'message' => 'API endpoint not found',
        'path' => $request->path()
    ], 404);
});