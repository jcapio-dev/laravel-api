<?php

use App\Http\Controllers\CoinsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(CoinsController::class)->prefix('coins')->group(function() {
    Route::get('/{coin}/current-price', 'getCurrentPrice');
    Route::patch('/{id}/refresh', 'refreshCoin');
    Route::post('/', 'store');
    Route::get('/', 'index');
    Route::delete('/{id}', 'destroy');
});