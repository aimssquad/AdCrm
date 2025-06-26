<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PasswordResetController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| All API routes here use the "api" middleware group.
| Ideal for mobile apps, frontend apps, or external integrations.
*/

// Public Routes
Route::post('/register', [AuthController::class, 'store'])->name('organization.register');
Route::post('/login', [AuthController::class, 'login'])->name('login');
// Password reset
// Password reset
Route::post('/password/forgot', [PasswordResetController::class, 'sendResetLink'])->name('password.forgot');
Route::get('/reset-password', [PasswordResetController::class, 'showResetData']);
Route::post('/password/reset', [PasswordResetController::class, 'resetPassword']);
Route::post('api/reset-password/{data}',[PasswordResetController::class,'getData']);

// Protected Routes - accessible only with valid Bearer token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Add other secure routes here...
     Route::post('/logout', [AuthController::class, 'logout']);
});
