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
Route::get('/pengumuman/{slug}', [\App\Http\Controllers\HomeController::class, 'pengumuman_lihat'])->name('pengumuman.detail');
Route::get('/galeri', [\App\Http\Controllers\HomeController::class, 'galeri'])->name('galeri');
Route::get('/donasi', [\App\Http\Controllers\HomeController::class, 'donasi'])->name('donasi');
Route::get('/pendaftaran', [\App\Http\Controllers\HomeController::class, 'pendaftaran'])->name('pendaftaran');
Route::get('/struktur', [\App\Http\Controllers\HomeController::class, 'struktur'])->name('struktur');
Route::get('/hubungi-kami', [\App\Http\Controllers\HomeController::class, 'hubungi'])->name('hubungi');


/*=== AUTH ===*/
Auth::routes([
    'verify' => true,
    'register' => false
]);

/*=== ROLE ROUTING ===*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*=== ROLE: KEPALA ===*/
Route::middleware(['kepala', 'auth', 'verified'])->prefix('kepala')->as('kepala.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Kepala\PageController::class, 'index'])->name('dashboard');

    /*=== ADMINISTRATOR ===*/
    Route::resource('admin', \App\Http\Controllers\Kepala\AdministratorController::class);

    /*=== PENGAJAR ===*/
    Route::resource('pengajar', \App\Http\Controllers\Kepala\PengajarController::class);

    /*=== PENGAJAR ===*/
    Route::get('santri', [\App\Http\Controllers\Kepala\SantriController::class, 'index'])->name('santri.index');
    Route::get('santri/{santri}', [\App\Http\Controllers\Kepala\SantriController::class, 'show'])->name('santri.show');

    /*=== KALENDER PENDIDIKAN ===*/
    Route::get('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'index'])->name('kalender.index');
    Route::post('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'store'])->name('kalender.store');
    Route::delete('kelender/{kalender}', [\App\Http\Controllers\Kepala\KalenderController::class, 'destroy'])->name('kalender.destroy');

    /*=== KELAS ===*/
    Route::resource('kelas', \App\Http\Controllers\Kepala\KelasController::class);

    /*=== KURIKULUM ===*/
    Route::resource('kurikulum', \App\Http\Controllers\Kepala\KurikulumController::class);
    Route::delete('kurikulum.delete', [\App\Http\Controllers\Kepala\KurikulumController::class, 'delete'])->name('kurikulum.delete');
    Route::post('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'add'])->name('kurikulum.mod');
    Route::put('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'mod'])->name('kurikulum.mod');

    /*=== KEUANGAN ===*/
    Route::prefix('keuangan')->as('keuangan.')->group(function () {

        /*=== KAS ===*/
        Route::get('kas', [\App\Http\Controllers\Kepala\KasController::class, 'index'])->name('kas.index');
        Route::get('kas/{kas}', [\App\Http\Controllers\Kepala\KasController::class, 'show'])->name('kas.show');

        Route::get('honor', [LaporanController::class, 'honor'])->name('honor');
        Route::get('spp', [LaporanController::class, 'spp'])->name('spp');
    });

    /*=== INVENTARIS ===*/
    Route::get('inventaris', [\App\Http\Controllers\Kepala\InventarisController::class, 'index'])->name('inventaris.index');
    Route::get('inventaris/{inventaris}', [\App\Http\Controllers\Kepala\InventarisController::class, 'show'])->name('inventaris.show');

    /*=== PENGATURAN ===*/
    Route::get('profil', [\App\Http\Controllers\Kepala\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Kepala\PageController::class, 'update'])->name('profil.update');
});

/*=== ROLE: ADMIN ===*/
Route::middleware(['admin', 'auth', 'verified'])->prefix('admin')->as('admin.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('dashboard');

    /*=== PENGAJAR ===*/
    Route::resource('pengajar', \App\Http\Controllers\Admin\PengajarController::class);
    Route::delete('pengajar/{pengajar}/foto', [\App\Http\Controllers\Admin\PengajarController::class, 'unlink'])->name('pengajar.unlink');

    /*=== SANTRI ===*/
    Route::resource('santri', \App\Http\Controllers\Admin\SantriController::class);
    Route::delete('santri/{santri}/foto', [\App\Http\Controllers\Admin\SantriController::class, 'unlink'])->name('santri.unlink');
    Route::post('wali', [\App\Http\Controllers\Admin\SantriController::class, 'wali'])->name('santri.wali');

    /*=== KALENDER ===*/
    Route::get('kalender', [\App\Http\Controllers\Admin\PageController::class, 'kalender'])->name('kalender.index');

    /*=== KURIKULUM ===*/
    Route::get('kurikulum', [\App\Http\Controllers\Admin\KurikulumController::class, 'index'])->name('kurikulum.index');
    Route::get('kurikulum/{kurikulum}', [\App\Http\Controllers\Admin\KurikulumController::class, 'show'])->name('kurikulum.show');

    /*=== KELAS ===*/
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);

    /*=== KEUANGAN ===*/
    Route::prefix('keuangan')->as('keuangan.')->group(function () {
        Route::resource('kas', \App\Http\Controllers\Admin\KasController::class);
        Route::delete('kas/{kas}/foto', [\App\Http\Controllers\Admin\KasController::class, 'unlink'])->name('kas.unlink');
    });

    /*=== SPP ===*/
    Route::prefix('spp')->as('spp.')->group(function () {

        /*=== OPSI ===*/
        Route::resource('opsi', \App\Http\Controllers\Admin\SppOpsiController::class);
    });

    /*=== KEHADIRAN ===*/
    Route::prefix('kehadiran')->as('kehadiran.')->group(function () {

        /*=== KEHADIRAN PENGAJAR ===*/
        Route::resource('pengajar', \App\Http\Controllers\Admin\KehadiranPengajarController::class);

        /*=== KEHADIRAN SANTRI ===*/
        Route::resource('santri', \App\Http\Controllers\Admin\KehadiranSantriController::class);
    });

    /*=== INVENTARIS ===*/
    Route::resource('inventaris', \App\Http\Controllers\Admin\InventarisController::class);
    Route::delete('inventasi/{inventasi}/foto', [\App\Http\Controllers\Admin\InventarisController::class, 'unlink'])->name('inventaris.unlink');

    /*=== FASILITAS ===*/
    Route::resource('fasilitas', \App\Http\Controllers\Admin\FasilitasController::class);

    /*=== PENGUMUMAN ===*/
    Route::resource('pengumuman', \App\Http\Controllers\Admin\PengumumanController::class);

    /*=== GALERI KEGIATAN ===*/
    Route::prefix('galeri')->as('galeri.')->group(function () {

        /*=== KATEGORI ===*/
        Route::resource('kategori', \App\Http\Controllers\Admin\KategoriGaleriController::class);
    });

    /*=== GALERI ===*/
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);

    /*=== PROFIL ===*/
    Route::get('profil', [\App\Http\Controllers\Admin\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('profil.update');
    Route::delete('profil', [\App\Http\Controllers\Admin\PageController::class, 'unlink'])->name('profil.unlink');

    /*=== LEMBAGA ===*/
    Route::resource('lembaga', \App\Http\Controllers\Admin\LembagaController::class);
});

/*=== ROLE: PENGAJAR ===*/
Route::middleware(['pengajar', 'auth'])->prefix('pengajar')->as('pengajar.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Pengajar\PageController::class, 'index'])->name('dashboard');

    /*=== KEHADIRAN ===*/
    Route::resource('kehadiran', \App\Http\Controllers\Pengajar\KehadiranPengajarController::class);
    Route::as('kehadiran.')->prefix('kehadiran')->group(function () {
        /*=== KEHADIRAN SANTRI ===*/
        Route::resource('santri', \App\Http\Controllers\Pengajar\KehadiranSantriController::class);
    });

    /*=== SANTRI ===*/
    Route::resource('pembelajaran', \App\Http\Controllers\Pengajar\PembelajaranController::class);

    /*=== SANTRI ===*/
    Route::get('santri', [\App\Http\Controllers\Pengajar\SantriController::class, 'index'])->name('santri.index');
    Route::get('santri/{santri}', [\App\Http\Controllers\Pengajar\SantriController::class, 'show'])->name('santri.show');

    /*=== KURIKULUM ===*/
    Route::get('kurikulum', [\App\Http\Controllers\Pengajar\PageController::class, 'kurikulum'])->name('kurikulum');
});
