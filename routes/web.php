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
Route::get('/pengumuman/{slug}', [\App\Http\Controllers\HomeController::class, 'show_pengumuman'])->name('pengumuman.detail');
Route::get('/galeri', [\App\Http\Controllers\HomeController::class, 'galeri'])->name('galeri');
Route::get('/donasi', [\App\Http\Controllers\HomeController::class, 'donasi'])->name('donasi');
Route::post('/donasi', [\App\Http\Controllers\HomeController::class, 'store_donasi'])->name('donasi.store');
Route::get('/pendaftaran', [\App\Http\Controllers\HomeController::class, 'pendaftaran'])->name('pendaftaran');
Route::post('/pendaftaran-final', [\App\Http\Controllers\HomeController::class, 'next_pendaftaran'])->name('pendaftaran.next');
Route::post('/pendaftaran', [\App\Http\Controllers\HomeController::class, 'post_pendaftaran'])->name('pendaftaran.post');
Route::get('/struktur', [\App\Http\Controllers\HomeController::class, 'struktur'])->name('struktur');
Route::get('/hubungi-kami', [\App\Http\Controllers\HomeController::class, 'hubungi'])->name('hubungi');
Route::post('/hubungi-kami', [\App\Http\Controllers\HomeController::class, 'store_hubungi'])->name('hubungi.store');

/*=== AUTH ===*/
Auth::routes([
    'verify' => false,
    'register' => false
]);

/*=== ROLE ROUTING ===*/
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*=== ROLE: KEPALA (OK) ===*/
Route::middleware(['kepala', 'auth'])->prefix('kepala')->as('kepala.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Kepala\PageController::class, 'index'])->name('dashboard');

    /*=== ADMINISTRATOR ===*/
    Route::resource('admin', \App\Http\Controllers\Kepala\AdministratorController::class);
    Route::delete('admin/{administrator}/foto', [\App\Http\Controllers\Kepala\AdministratorController::class, 'unlink'])->name('admin.unlink');

    /*=== PENGAJAR ===*/
    Route::get('pengajar/import', [\App\Http\Controllers\Kepala\PengajarController::class, 'upload'])->name('pengajar.upload');
    Route::post('pengajar/import', [\App\Http\Controllers\Kepala\PengajarController::class, 'import'])->name('pengajar.import');
    Route::resource('pengajar', \App\Http\Controllers\Kepala\PengajarController::class);
    Route::delete('pengajar/{pengajar}/foto', [\App\Http\Controllers\Kepala\PengajarController::class, 'unlink'])->name('pengajar.unlink');

    /*=== SANTRI ===*/
    Route::get('santri', [\App\Http\Controllers\Kepala\SantriController::class, 'index'])->name('santri.index');
    Route::get('santri/{santri}', [\App\Http\Controllers\Kepala\SantriController::class, 'show'])->name('santri.show');
    Route::get('santri/hafalan/{santri}', [\App\Http\Controllers\Kepala\SantriController::class, 'show_hafalan'])->name('santri.hafalan');
    Route::get('santri/kehadiran/{santri}', [\App\Http\Controllers\Kepala\SantriController::class, 'show_kehadiran'])->name('santri.kehadiran');
    Route::get('santri/pembelajaran/{santri}', [\App\Http\Controllers\Kepala\SantriController::class, 'show_pembelajaran'])->name('santri.pembelajaran');

    /*=== KALENDER PENDIDIKAN ===*/
    Route::get('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'index'])->name('kalender.index');
    Route::post('kalender', [\App\Http\Controllers\Kepala\KalenderController::class, 'store'])->name('kalender.store');
    Route::delete('kelender/{kalender}', [\App\Http\Controllers\Kepala\KalenderController::class, 'destroy'])->name('kalender.destroy');

    /*=== KELAS ===*/
    Route::resource('kelas', \App\Http\Controllers\Kepala\KelasController::class);

    /*=== KURIKULUM ===*/
    Route::resource('kurikulum', \App\Http\Controllers\Kepala\KurikulumController::class);
    Route::delete('kurikulum.delete', [\App\Http\Controllers\Kepala\KurikulumController::class, 'delete'])->name('kurikulum.delete');
    Route::post('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'add'])->name('kurikulum.add');
    Route::put('kurikulum.mod', [\App\Http\Controllers\Kepala\KurikulumController::class, 'mod'])->name('kurikulum.mod');

    /*=== KEUANGAN ===*/
    Route::prefix('keuangan')->as('keuangan.')->group(function () {

        /*=== KAS ===*/
        Route::get('kas', [\App\Http\Controllers\Kepala\KeuanganController::class, 'kas'])->name('kas.index');

        /*=== HONOR PENGAJAR ===*/
        Route::get('honor', [\App\Http\Controllers\Kepala\KeuanganController::class, 'honor'])->name('honor.index');

        /*=== SPP SANTRI ===*/
        Route::get('spp', [\App\Http\Controllers\Kepala\KeuanganController::class, 'spp'])->name('spp.index');

        /*=== DONASI ===*/
        Route::get('donasi', [\App\Http\Controllers\Kepala\KeuanganController::class, 'donasi'])->name('donasi.index');

    });

    /*=== KEHADIRAN ===*/
    Route::prefix('kehadiran')->as('kehadiran.')->group(function() {

        /*=== PENGAJAR ===*/
        Route::get('pengajar', [\App\Http\Controllers\Kepala\KehadiranController::class, 'pengajar'])->name('pengajar.index');

        /*=== SANTRI ===*/
        Route::get('santri', [\App\Http\Controllers\Kepala\KehadiranController::class, 'santri'])->name('santri.index');
    });

    /*=== INVENTARIS ===*/
    Route::get('inventaris', [\App\Http\Controllers\Kepala\PageController::class, 'inventaris'])->name('inventaris.index');

    /*=== PENGATURAN ===*/
    Route::get('akun', [\App\Http\Controllers\Kepala\PageController::class, 'akun'])->name('akun');
    Route::put('akun', [\App\Http\Controllers\Kepala\PageController::class, 'update_akun'])->name('akun.update');
    Route::get('profil', [\App\Http\Controllers\Kepala\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Kepala\PageController::class, 'update'])->name('profil.update');
    Route::delete('profil', [\App\Http\Controllers\Kepala\PageController::class, 'unlink'])->name('profil.unlink');

    /*=== LEMBAGA ===*/
    Route::resource('lembaga', \App\Http\Controllers\Kepala\LembagaController::class);
    Route::delete('lembaga', [\App\Http\Controllers\Kepala\LembagaController::class, 'unlink'])->name('lembaga.unlink');
    Route::put('pendaftaran/{lembaga}', [\App\Http\Controllers\Kepala\LembagaController::class, 'registration'])->name('pendaftaran.update');
});

/*=== ROLE: ADMIN (OK) ===*/
Route::middleware(['admin', 'auth'])->prefix('admin')->as('admin.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('dashboard');

    /*=== PENGAJAR ===*/
    Route::get('pengajar/import', [\App\Http\Controllers\Admin\PengajarController::class, 'upload'])->name('pengajar.upload');
    Route::post('pengajar/import', [\App\Http\Controllers\Admin\PengajarController::class, 'import'])->name('pengajar.import');
    Route::resource('pengajar', \App\Http\Controllers\Admin\PengajarController::class);
    Route::delete('pengajar/{pengajar}/foto', [\App\Http\Controllers\Admin\PengajarController::class, 'unlink'])->name('pengajar.unlink');

    /*=== SANTRI ===*/
    Route::get('santri/import', [\App\Http\Controllers\Admin\SantriController::class, 'upload'])->name('santri.upload');
    Route::post('santri/import', [\App\Http\Controllers\Admin\SantriController::class, 'import'])->name('santri.import');
    Route::resource('santri', \App\Http\Controllers\Admin\SantriController::class);
    Route::delete('santri/{santri}/foto', [\App\Http\Controllers\Admin\SantriController::class, 'unlink'])->name('santri.unlink');
    Route::get('hafalan/{santri}', [\App\Http\Controllers\Admin\SantriController::class, 'show_hafalan'])->name('santri.hafalan');
    Route::get('pembelajaran/{santri}', [\App\Http\Controllers\Admin\SantriController::class, 'show_pembelajaran'])->name('santri.pembelajaran');
    Route::post('wali', [\App\Http\Controllers\Admin\SantriController::class, 'wali'])->name('santri.wali');
    Route::put('accept/{santri}', [\App\Http\Controllers\Admin\SantriController::class, 'accept'])->name('santri.accept');

    /*=== KALENDER ===*/
    Route::get('kalender', [\App\Http\Controllers\Admin\PageController::class, 'kalender'])->name('kalender.index');

    /*=== KURIKULUM ===*/
    Route::get('kurikulum', [\App\Http\Controllers\Admin\KurikulumController::class, 'index'])->name('kurikulum.index');
    Route::get('kurikulum/{kurikulum}', [\App\Http\Controllers\Admin\KurikulumController::class, 'show'])->name('kurikulum.show');

    /*=== KELAS ===*/
    Route::resource('kelas', \App\Http\Controllers\Admin\KelasController::class);

    /*=== KEUANGAN ===*/
    Route::prefix('keuangan')->as('keuangan.')->group(function () {

        /*=== KAS ===*/
        Route::get('kas/import', [\App\Http\Controllers\Admin\KasController::class, 'upload'])->name('kas.upload');
        Route::post('kas/import', [\App\Http\Controllers\Admin\KasController::class, 'import'])->name('kas.import');
        Route::resource('kas', \App\Http\Controllers\Admin\KasController::class);
        Route::delete('kas/{kas}/foto', [\App\Http\Controllers\Admin\KasController::class, 'unlink'])->name('kas.unlink');

        /*=== HONOR ===*/
        Route::resource('honor', \App\Http\Controllers\Admin\HonorController::class);
        Route::post('honor/collect', [\App\Http\Controllers\Admin\HonorController::class, 'collect'])->name('honor.collect');

        /*=== Donasi ===*/
        Route::resource('donasi', \App\Http\Controllers\Admin\DonasiController::class);
    });

    /*=== SPP ===*/
    Route::resource('spp', \App\Http\Controllers\Admin\SppController::class);
    Route::post('spp/collect', [\App\Http\Controllers\Admin\SppController::class, 'collect'])->name('spp.collect');
    /*=== SPP OPSI ===*/
    Route::resource('ssp/opsi', \App\Http\Controllers\Admin\SppOpsiController::class, ['as' => 'spp']);

    /*=== KEHADIRAN ===*/
    Route::prefix('kehadiran')->as('kehadiran.')->group(function () {

        /*=== KEHADIRAN PENGAJAR ===*/
        Route::get('pengajar/import', [\App\Http\Controllers\Admin\KehadiranPengajarController::class, 'upload'])->name('pengajar.upload');
        Route::post('pengajar/import', [\App\Http\Controllers\Admin\KehadiranPengajarController::class, 'import'])->name('pengajar.import');
        Route::resource('pengajar', \App\Http\Controllers\Admin\KehadiranPengajarController::class);

        /*=== KEHADIRAN SANTRI ===*/
        Route::get('santri/import', [\App\Http\Controllers\Admin\KehadiranSantriController::class, 'upload'])->name('santri.upload');
        Route::post('santri/import', [\App\Http\Controllers\Admin\KehadiranSantriController::class, 'import'])->name('santri.import');
        Route::resource('santri', \App\Http\Controllers\Admin\KehadiranSantriController::class);
    });

    /*=== INVENTARIS ===*/
    Route::resource('inventaris', \App\Http\Controllers\Admin\InventarisController::class);
    Route::delete('inventasi/{inventasi}/foto', [\App\Http\Controllers\Admin\InventarisController::class, 'unlink'])->name('inventaris.unlink');

    /*=== FASILITAS ===*/
    Route::resource('fasilitas', \App\Http\Controllers\Admin\FasilitasController::class);

    /*=== PENGUMUMAN ===*/
    Route::resource('pengumuman', \App\Http\Controllers\Admin\PengumumanController::class);

    /*=== PESAN ===*/
    Route::resource('pesan', \App\Http\Controllers\Admin\KontakController::class);

    /*=== GALERI KATEGORI ===*/
    Route::resource('galeri/kategori', \App\Http\Controllers\Admin\KategoriGaleriController::class, ['as' => 'galeri']);

    /*=== GALERI ===*/
    Route::resource('galeri', \App\Http\Controllers\Admin\GaleriController::class);

    /*=== PROFIL ===*/
    Route::get('profil', [\App\Http\Controllers\Admin\PageController::class, 'profil'])->name('profil');
    Route::get('akun', [\App\Http\Controllers\Admin\PageController::class, 'akun'])->name('akun');
    Route::put('akun', [\App\Http\Controllers\Admin\PageController::class, 'update_akun'])->name('akun.update');
    Route::put('profil', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('profil.update');
    Route::delete('profil', [\App\Http\Controllers\Admin\PageController::class, 'unlink'])->name('profil.unlink');


    /*=== LEMBAGA ===*/
    Route::resource('lembaga', \App\Http\Controllers\Admin\LembagaController::class);
    Route::delete('lembaga', [\App\Http\Controllers\Admin\LembagaController::class, 'unlink'])->name('lembaga.unlink');
    Route::put('pendaftaran/{lembaga}', [\App\Http\Controllers\Admin\LembagaController::class, 'registration'])->name('pendaftaran.update');
});

/*=== ROLE: PENGAJAR (OK) ===*/
Route::middleware(['pengajar', 'auth'])->prefix('pengajar')->as('pengajar.')->group(function () {

    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Pengajar\PageController::class, 'index'])->name('dashboard');

    /*=== PENGUMUMAN ===*/
    Route::resource('pengumuman', \App\Http\Controllers\Pengajar\PengumumanController::class);

    /*=== KEHADIRAN ===*/
    Route::resource('kehadiran', \App\Http\Controllers\Pengajar\KehadiranPengajarController::class);
    Route::as('kehadiran.')->prefix('kehadiran')->group(function () {
        /*=== KEHADIRAN SANTRI ===*/
        Route::resource('santri', \App\Http\Controllers\Pengajar\KehadiranSantriController::class);
    });

    /*=== PEMBELAJARAN ===*/
    Route::resource('pembelajaran', \App\Http\Controllers\Pengajar\PembelajaranController::class);
    Route::resource('hafalan', \App\Http\Controllers\Pengajar\HafalanController::class);

    /*=== SANTRI ===*/
    Route::get('santri', [\App\Http\Controllers\Pengajar\SantriController::class, 'index'])->name('santri.index');
    Route::get('santri/{santri}', [\App\Http\Controllers\Pengajar\SantriController::class, 'show'])->name('santri.show');

    /*=== HONOR ===*/
    Route::resource('honor', \App\Http\Controllers\Pengajar\HonorController::class);

    /*=== KURIKULUM ===*/
    Route::get('kurikulum', [\App\Http\Controllers\Pengajar\PageController::class, 'kurikulum'])->name('kurikulum');

    /*=== PROFIL ===*/
    Route::get('akun', [\App\Http\Controllers\Pengajar\PageController::class, 'akun'])->name('akun');
    Route::put('akun', [\App\Http\Controllers\Pengajar\PageController::class, 'update_akun'])->name('akun.update');
    Route::get('profil', [\App\Http\Controllers\Pengajar\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Pengajar\PageController::class, 'update'])->name('profil.update');
    Route::delete('profil', [\App\Http\Controllers\Pengajar\PageController::class, 'unlink'])->name('profil.unlink');
});

/*=== ROLE: SANTRI (OK) ===*/
Route::middleware(['santri', 'auth'])->prefix('santri')->as('santri.')->group(function () {
    /*=== DASHBOARD ===*/
    Route::get('/', [\App\Http\Controllers\Santri\PageController::class, 'index'])->name('dashboard');

    /*=== KEHADIRAN ===*/
    Route::get('kehadiran', [\App\Http\Controllers\Santri\PageController::class, 'show_kehadiran'])->name('kehadiran');

    /*=== PEMBELAJARAN ===*/
    Route::resource('spp', \App\Http\Controllers\Santri\SppController::class);

    /*=== PEMBELAJARAN ===*/
    Route::get('pembelajaran', [\App\Http\Controllers\Santri\PageController::class, 'show_pembelajaran'])->name('pembelajaran');

    /*=== HAFALAN ===*/
    Route::get('hafalan', [\App\Http\Controllers\Santri\PageController::class, 'show_hafalan'])->name('hafalan');

    /*=== PENGUMUMAN ===*/
    Route::resource('pengumuman', \App\Http\Controllers\Santri\PengumumanController::class);

    /*=== KELAS ===*/
    Route::get('kelas', [\App\Http\Controllers\Santri\PageController::class, 'kelas'])->name('kelas');

    /*=== PROFIL ===*/
    Route::get('akun', [\App\Http\Controllers\Santri\PageController::class, 'akun'])->name('akun');
    Route::put('akun', [\App\Http\Controllers\Santri\PageController::class, 'update_akun'])->name('akun.update');
    Route::get('profil', [\App\Http\Controllers\Santri\PageController::class, 'profil'])->name('profil');
    Route::put('profil', [\App\Http\Controllers\Santri\PageController::class, 'update'])->name('profil.update');
    Route::delete('profil', [\App\Http\Controllers\Santri\PageController::class, 'unlink'])->name('profil.unlink');
});
