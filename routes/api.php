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


/*=== LOGIN ===*/
Route::post('login', [\App\Http\Controllers\API\UserController::class, 'login']);

/*=== AUTHENTICATED ===*/
Route::middleware('auth:sanctum')->group(function() {

    /*=== LOGOUT ===*/
    Route::post('logout', [\App\Http\Controllers\API\UserController::class, 'logout']);

    /*=== HONOR ===*/
    Route::get('honor', [\App\Http\Controllers\API\HonorController::class, 'all']);
    Route::put('honor', [\App\Http\Controllers\API\HonorController::class, 'update']);

    /*=== KEHADIRAN ===*/
    Route::get('kehadiran', [\App\Http\Controllers\API\KehadiranPengajarController::class, 'all']);
    Route::post('kehadiran', [\App\Http\Controllers\API\KehadiranPengajarController::class, 'store']);
    Route::put('kehadiran', [\App\Http\Controllers\API\KehadiranPengajarController::class, 'update']);
    Route::get('kehadiran/bulan', [\App\Http\Controllers\API\KehadiranPengajarController::class, 'month']);

    /*=== SANTRI ===*/
    Route::get('santri', [\App\Http\Controllers\API\SantriController::class, 'all']);

    /*=== KEHADIRAN SANTRI ===*/
    Route::get('santri/kehadiran', [\App\Http\Controllers\API\KehadiranSantriController::class, 'all']);
    Route::post('santri/kehadiran', [\App\Http\Controllers\API\KehadiranSantriController::class, 'store']);
    Route::get('santri/kehadiran/bulan', [\App\Http\Controllers\API\KehadiranSantriController::class, 'month']);

    /*=== PEMBELAJARAN SANTRI ===*/
    Route::get('santri/pembelajaran', [\App\Http\Controllers\API\PembelajaranController::class, 'all']);
    Route::post('santri/pembelajaran', [\App\Http\Controllers\API\PembelajaranController::class, 'store']);
    Route::get('santri/pembelajaran/bulan', [\App\Http\Controllers\API\PembelajaranController::class, 'month']);
    Route::get('santri/pembelajaran/materi', [\App\Http\Controllers\API\PembelajaranController::class, 'materials']);

    /*=== HAFALAN SANTRI ===*/
    Route::get('santri/hafalan', [\App\Http\Controllers\API\HafalanController::class, 'all']);
    Route::post('santri/hafalan', [\App\Http\Controllers\API\HafalanController::class, 'store']);
    Route::get('santri/hafalan/bulan', [\App\Http\Controllers\API\HafalanController::class, 'month']);
    Route::get('santri/hafalan/materi', [\App\Http\Controllers\API\HafalanController::class, 'materials']);

    /*=== KURIKULUM ===*/
    Route::get('kurikulum', [\App\Http\Controllers\API\KurikulumController::class, 'all']);

    /*=== PROFILE ===*/
    Route::get('user', [\App\Http\Controllers\API\UserController::class, 'get']);
    Route::post('user', [\App\Http\Controllers\API\UserController::class, 'update']);
    Route::put('user', [\App\Http\Controllers\API\UserController::class, 'upload']);
});
