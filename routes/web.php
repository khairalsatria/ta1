<?php


use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Admin\JenisKelasController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jenis_kelas', JenisKelasController::class);
});

use App\Http\Controllers\Admin\DashboardController;
// Route admin dashboard tanpa middleware auth
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
});

use App\Http\Controllers\Admin\MataPelajaranController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('mata_pelajaran', MataPelajaranController::class);
});

use App\Http\Controllers\Admin\JenjangPendidikanController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jenjang_pendidikan', JenjangPendidikanController::class);
});

use App\Http\Controllers\Admin\PaketGuideController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('paket_guide', PaketGuideController::class);
});

use App\Http\Controllers\Admin\KontakController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kontak', KontakController::class);
});

use App\Http\Controllers\Admin\GenzeLearnController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('genze_learn', GenzeLearnController::class);
});

use App\Http\Controllers\Admin\JadwalKelasController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jadwal_kelas', JadwalKelasController::class);
});

use App\Http\Controllers\Admin\JadwalGuide2Controller;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jadwal_guide2', JadwalGuide2Controller::class);
});

use App\Http\Controllers\Admin\KategoriBlogController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori_blog', KategoriBlogController::class);
});

use App\Http\Controllers\Admin\BlogController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('blog', BlogController::class);
});

use App\Http\Controllers\Admin\GenzeGuideController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('genze_guides', GenzeGuideController::class);
});

use App\Http\Controllers\Admin\PromosiClassController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('promosi_class', PromosiClassController::class);
});

// use App\Http\Controllers\Siswa\PendaftaranController as SiswaPendaftaranController;
// use App\Http\Controllers\Admin\PendaftaranController as AdminPendaftaranController;

// // Route siswa
// Route::prefix('siswa')->name('siswa.')->group(function () {
//     Route::get('/pendaftaran', [SiswaPendaftaranController::class, 'create'])->name('pendaftaran.form');
//     Route::post('/pendaftaran', [SiswaPendaftaranController::class, 'store'])->name('pendaftaran.store');
//     Route::get('/upload-bukti/{id}', [SiswaPendaftaranController::class, 'uploadForm'])->name('pendaftaran.uploadForm');
//     Route::post('/upload-bukti/{id}', [SiswaPendaftaranController::class, 'uploadBukti'])->name('pendaftaran.uploadBukti');
// });

// Route admin
// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::get('/pendaftaran/{id}/konfirmasi-jadwal', [AdminPendaftaranController::class, 'konfirmasiJadwalForm'])->name('pendaftaran.konfirmasiJadwalForm');
//     Route::post('/pendaftaran/{id}/konfirmasi-jadwal', [AdminPendaftaranController::class, 'konfirmasiJadwal'])->name('pendaftaran.konfirmasiJadwal');
// });

// AJAX
// Route::get('/mata-pelajaran/by-jenjang/{id}', [SiswaPendaftaranController::class, 'mataPelajaranByJenjang']);

// Route::get('/pendaftaran/{id}/verifikasi-pembayaran', [AdminPendaftaranController::class, 'verifikasiPembayaranForm'])->name('pendaftaran.verifikasiPembayaranForm');
// Route::post('/pendaftaran/{id}/verifikasi-pembayaran', [AdminPendaftaranController::class, 'verifikasiPembayaran'])->name('pendaftaran.verifikasiPembayaran');

// Route::get('/siswa/dashboard/email', [SiswaPendaftaranController::class, 'formEmail'])->name('siswa.dashboard.form');
// Route::post('/siswa/dashboard', [SiswaPendaftaranController::class, 'dashboard'])->name('siswa.dashboard');

Route::get('/mata-pelajaran/by-jenjang/{id}', function ($id) {
    $mataPelajaran = \App\Models\MataPelajaran::where('jenjang_pendidikan', $id)->get();
    return response()->json($mataPelajaran);
});

// use App\Http\Controllers\Admin\PendaftaranController;

// Route::post('/admin/pendaftaran/verifikasi-pembayaran/{id}', [PendaftaranController::class, 'verifikasiPembayaran'])
//     ->name('admin.pendaftaran.verifikasiPembayaran');

// routes/web.php

use App\Http\Controllers\Admin\PendaftaranController;

Route::prefix('admin')->group(function () {
    Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('admin.pendaftaran.index');
    Route::get('/pendaftaran/{id}', [PendaftaranController::class, 'show'])->name('admin.pendaftaran.show');
    Route::post('/pendaftaran/{id}/konfirmasi-jadwal', [PendaftaranController::class, 'konfirmasiJadwal'])->name('admin.pendaftaran.konfirmasiJadwal');
    Route::get('/pendaftaran/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'showVerifikasiPembayaranForm'])->name('admin.pendaftaran.showVerifikasiPembayaranForm');
    Route::post('/pendaftaran/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'verifikasiPembayaran'])->name('admin.pendaftaran.verifikasiPembayaran');
});



use App\Http\Controllers\Siswa\PendaftaranController as SiswaPendaftaranController;

use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;
// Route siswa dashboard tanpa middleware auth
Route::prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
    Route::get('/pendaftaran', [SiswaPendaftaranController::class, 'create'])->name('siswa.pendaftaran.form');
Route::post('/pendaftaran', [SiswaPendaftaranController::class, 'store'])->name('siswa.pendaftaran.store');
Route::get('/pendaftaran/email/{id}', [SiswaPendaftaranController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');
Route::post('/pendaftaran/dashboard/{id}', [SiswaPendaftaranController::class, 'dashboard'])->name('siswa.pendaftaran.dashboard');
Route::get('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadForm'])->name('siswa.pendaftaran.uploadForm');
Route::post('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadBukti'])->name('siswa.pendaftaran.uploadBukti');
});
