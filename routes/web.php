<?php


use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\Admin\JenisKelasController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('jenis_kelas', JenisKelasController::class);
});

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
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

use App\Http\Controllers\Admin\MediaPartnerController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('media-partners', MediaPartnerController::class);
});

use App\Http\Controllers\Admin\GenzeGuideController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('genze_guides', GenzeGuideController::class);
});

use App\Http\Controllers\Admin\PromosiClassController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('promosi_class', PromosiClassController::class);
});

use App\Http\Controllers\Admin\MentorController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('mentor', MentorController::class);
});

use App\Http\Controllers\Admin\UserController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('user', UserController::class);
});

use App\Http\Controllers\Admin\ProgramController;
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('program', ProgramController::class);
});

use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;
Route::prefix('mentor')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('mentor.dashboard');
});



Route::get('/mata-pelajaran/by-jenjang/{id}', function ($id) {
    $mataPelajaran = \App\Models\MataPelajaran::where('jenjang_pendidikan', $id)->get();
    return response()->json($mataPelajaran);
});

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
Route::prefix('siswa')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');
    Route::get('/pendaftaran', [SiswaPendaftaranController::class, 'create'])->name('siswa.pendaftaran.form');
Route::post('/pendaftaran', [SiswaPendaftaranController::class, 'store'])->name('siswa.pendaftaran.store');
Route::get('/pendaftaran/email/{id}', [SiswaPendaftaranController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');
Route::post('/pendaftaran/dashboard/{id}', [SiswaPendaftaranController::class, 'dashboard'])->name('siswa.pendaftaran.dashboard');
Route::get('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadForm'])->name('siswa.pendaftaran.uploadForm');
Route::post('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadBukti'])->name('siswa.pendaftaran.uploadBukti');
});

use App\Http\Controllers\Landing\PageController;
Route::get('/home', [PageController::class, 'home'])->name('landing.page.home');
Route::get('/about', [PageController::class, 'about'])->name(name: 'landing.page.about');
Route::get('/program', [PageController::class, 'program'])->name(name: 'landing.page.program');
Route::get('/program/{id}', [PageController::class, 'detailProgram'])->name(name: 'landing.page.detail-program');
Route::get('/team', [PageController::class, 'team'])->name(name: 'landing.page.team');
Route::get('/kontak', [PageController::class, 'kontak'])->name(name: 'landing.page.kontak');


use App\Http\Controllers\Auth\GoogleController;
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);


use App\Http\Controllers\PendaftaranProgramController;
use App\Http\Controllers\PendaftaranClassController;
use App\Http\Controllers\PendaftaranGuideController;
use App\Http\Controllers\PendaftaranLearnController;
Route::post('/pendaftaran/store', [PendaftaranProgramController::class, 'store'])->name('pendaftaran.program.store');
// Route Siswa - GenZE Class
Route::prefix('siswa/pendaftaran/genze-class')->name('siswa.pendaftaran.genze-class.')->group(function () {
    Route::get('/', [PendaftaranClassController::class, 'create'])->name('form');
    Route::post('/store', [PendaftaranClassController::class, 'store'])->name('store');
});
Route::get('/mata-pelajaran/by-jenjang/{id}', [PendaftaranClassController::class, 'mataPelajaranByJenjang'])->name('mata-pelajaran.by-jenjang');

Route::get('/siswa/pendaftaran/email/{id}', [PendaftaranClassController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');

Route::get('/pendaftaran/genze-class/{program_id}', [PendaftaranClassController::class, 'create'])->name('siswa.pendaftaran.genze-class.form');

// Route::middleware('auth')->group(function () {
//     Route::post('/pendaftaran-program', [PendaftaranProgramController::class, 'store'])->name('pendaftaran.program.store');

//     // Genze Class
//     Route::get('/pendaftaran/class/{id}', [PendaftaranClassesController::class, 'create'])->name('siswa.pendaftaran.class');
//     Route::post('/pendaftaran/class/{id}', [PendaftaranClassesController::class, 'store'])->name('pendaftaran.class.store');
//     Route::post('/pendaftaran/class/konfirmasi/{id}', [PendaftaranClassesController::class, 'konfirmasiJadwal'])->name('pendaftaran.class.konfirmasi');

//     // Genze Guide
//     Route::get('/pendaftaran/guide/{id}', [PendaftaranGuidesController::class, 'create'])->name('pendaftaran.guide.create');
//     Route::post('/pendaftaran/guide/{id}', [PendaftaranGuidesController::class, 'store'])->name('pendaftaran.guide.store');
//     Route::post('/pendaftaran/guide/konfirmasi/{id}', [PendaftaranGuidesController::class, 'konfirmasiJadwal'])->name('pendaftaran.guide.konfirmasi');

//     // Genze Learn
//     Route::get('/pendaftaran/learn/{id}', [PendaftaranLearnsController::class, 'create'])->name('pendaftaran.learn.create');
//     Route::post('/pendaftaran/learn/{id}', [PendaftaranLearnsController::class, 'store'])->name('pendaftaran.learn.store');
//     Route::post('/pendaftaran/learn/sertifikat/{id}', [PendaftaranLearnsController::class, 'uploadSertifikat'])->name('pendaftaran.learn.sertifikat');

//     // Umum
//     Route::post('/pendaftaran/upload-bukti/{id}', [PendaftaranProgramController::class, 'uploadBukti'])->name('pendaftaran.upload.bukti');
//     Route::post('/pendaftaran/verifikasi/{id}/{status}', [PendaftaranProgramController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
// });



