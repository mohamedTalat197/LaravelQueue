<?php

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
use Illuminate\Http\Request;

/** Start Auth Route **/

/** Auth_general */
Route::prefix('auth')->group(function () {
    Route::post('/register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
});

Route::middleware('auth:api')->group(function () {
    /** auth private */
    Route::prefix('vendor')->group(function()
    {
        Route::post('/create', [\App\Http\Controllers\Api\VendorController::class, 'create']);
        Route::get('/get', [\App\Http\Controllers\Api\VendorController::class, 'get']);

    });
});

Route::get('/changeStatus', [\App\Http\Controllers\Api\VendorController::class, 'changeStatus']);


