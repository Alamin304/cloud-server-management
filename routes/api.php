<?php

use App\Http\Controllers\API\ServerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('servers', ServerController::class);
Route::post('servers/bulk-delete', [ServerController::class, 'bulkDestroy'])->name('servers.bulk-delete');
