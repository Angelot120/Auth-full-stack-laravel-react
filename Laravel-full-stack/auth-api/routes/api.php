<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('/v1.0.0')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('otp-code', [AuthController::class, 'checkOtpCode']);

    // Route::get('users', [UserController::class, 'index'])->middleware('auth:sanctum');
    // Route::delete('logout', [UserController::class, 'index'])->middleware('auth:sanctum');

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('users', [UserController::class, 'index']);
        Route::get('logout', [AuthController::class, 'logout']);
    });
});




