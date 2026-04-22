<?php

use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});


Route::fallback(function (Request $request) {
    return response()->json([
        'message' => 'API endpoint not found',
        'path' => $request->path()
    ], 404);
});