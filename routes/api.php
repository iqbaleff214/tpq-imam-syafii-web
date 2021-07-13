<?php

use Illuminate\Http\Request;
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


Route::get('kurikulum', [\App\Http\Controllers\API\KurikulumController::class, 'all']);

Route::post('login', [\App\Http\Controllers\API\UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('user', [\App\Http\Controllers\API\UserController::class, 'fetch']);
    Route::post('user', [\App\Http\Controllers\API\UserController::class, 'editProfile']);
    Route::post('logout', [\App\Http\Controllers\API\UserController::class, 'logout']);
});
