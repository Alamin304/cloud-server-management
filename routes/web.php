<?php

use App\Http\Controllers\ServerController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('servers.index');
});

Auth::routes();

// Protected routes that require authentication
Route::middleware('auth')->group(function () {
    Route::resource('servers', ServerController::class);
    Route::post('servers/bulk-delete', [ServerController::class, 'bulkDestroy'])->name('servers.bulk-delete');
});

Route::get('/home', function () {
    return redirect()->route('servers.index');
})->name('home');
