<?php

use App\Http\Controllers\Kepala\LaporanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*=== LANDING PAGE ===*/
Route::get('/', [\App\Http\Controllers\HomeController::class, 'beranda'])->name('beranda');
Route::get('/pengumuman', [\App\Http\Controllers\HomeController::class, 'pengumuman'])->name('pengumuman');
Route::get('/galeri', [\App\Http\Controllers\HomeController::class, 'galeri'])->name('galeri');
Route::get('/donasi', [\App\Http\Controllers\HomeController::class, 'donasi'])->name('donasi');
Route::get('/pendaftaran', [\App\Http\Controllers\HomeController::class, 'pendaftaran'])->name('pendaftaran');
Route::get('/pengelola', [\App\Http\Controllers\HomeController::class, 'pengelola'])->name('pengelola');
Route::get('/hubungi-kami', [\App\Http\Controllers\HomeController::class, 'hubungi'])->name('hubungi');


/*=== AUTH ===*/
Auth::routes(['verify' => true]);

/*=== ROLE ROUTING ===*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*=== ROLE: KEPALA ===*/
Route::middleware(['kepala', 'auth', 'verified'])->prefix('kepala')->as('kepala.')->group(function() {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Kepala\PageController::class, 'index'])->name('dashboard');

    /*=== ADMINISTRATOR ===*/
    Route::resource('admin', \App\Http\Controllers\Kepala\AdministratorController::class);

    /*=== PENGAJAR ===*/
    Route::resource('pengajar', \App\Http\Controllers\Kepala\PengajarController::class);

    /*=== KALENDER PENDIDIKAN ===*/
    Route::get('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'index'])->name('kalender.index');
    Route::post('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'event'])->name('kalender.event');

    /*=== KELAS ===*/
    Route::resource('kelas', \App\Http\Controllers\Kepala\KelasController::class);

    /*=== KURIKULUM ===*/
    Route::resource('kurikulum', \App\Http\Controllers\Kepala\KurikulumController::class);
    Route::delete('kurikulum.delete', [\App\Http\Controllers\Kepala\KurikulumController::class, 'delete'])->name('kurikulum.delete');
    Route::post('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'add'])->name('kurikulum.mod');
    Route::put('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'mod'])->name('kurikulum.mod');

    /*=== LAPORAN ===*/
    Route::prefix('keuangan')->as('keuangan.')->group(function() {
        Route::get('kas', [LaporanController::class, 'kas'])->name('kas');
        Route::get('honor', [LaporanController::class, 'honor'])->name('honor');
        Route::get('spp', [LaporanController::class, 'spp'])->name('spp');
    });

    /*=== PENGATURAN ===*/
    Route::get('profil', [\App\Http\Controllers\Kepala\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Kepala\PageController::class, 'update'])->name('profil.update');

});

/*=== ROLE: ADMIN ===*/
Route::middleware(['admin', 'auth'])->prefix('admin')->as('admin.')->group(function() {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('dashboard');

    /*=== PENGAJAR ===*/
    Route::resource('pengajar', \App\Http\Controllers\Admin\PengajarController::class);

    Route::get('/tesi', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('santri.index');

    /*=== PENGATURAN ===*/
    Route::get('profil', [\App\Http\Controllers\Admin\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('profil.update');
});

