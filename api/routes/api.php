<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('order')->group(function () {
    Route::post('/create', [OrderController::class, 'create']);
    Route::post('/purchase', [OrderController::class, 'purchase']);
    Route::get('/list', [OrderController::class, 'list']);
});

Route::prefix('voucher')->group(function () {
    Route::post('/create', [VoucherController::class, 'create']);
    Route::post('/update', [VoucherController::class, 'update']);
    Route::post('/delete', [VoucherController::class, 'delete']);
    Route::get('/list', [VoucherController::class, 'list']);
});
