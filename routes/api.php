<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;


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

// Protected Routes - accessible only with valid Bearer token
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Add other secure routes here...
     Route::post('/logout', [AuthController::class, 'logout']);
});
