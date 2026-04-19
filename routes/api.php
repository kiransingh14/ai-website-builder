<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/logout',  [AuthController::class, 'logout']);
});


Route::fallback(function (Request $request) {
    return response()->json([
        'message' => 'API endpoint not found',
        'path' => $request->path()
    ], 404);
});