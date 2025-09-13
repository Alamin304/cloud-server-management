<?php
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ServerController;
use Illuminate\Support\Facades\Route;

// Auth routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::apiResource('servers', ServerController::class);
    Route::post('servers/bulk-delete', [ServerController::class, 'bulkDestroy'])->name('servers.bulk-delete');
});

