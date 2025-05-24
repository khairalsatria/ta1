<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    JenisKelasController,
    DashboardController as AdminDashboardController,
    MataPelajaranController,
    JenjangPendidikanController,
    PaketGuideController,
    KontakController,
    GenzeLearnController,
    JadwalKelasController,
    JadwalGuide2Controller,
    KategoriBlogController,
    BlogController,
    MediaPartnerController,
    GenzeGuideController,
    PromosiClassController,
    MentorController,
    UserController,
    ProgramController,
    PendaftaranProgramController as AdminPendaftaranProgramController,
    PendaftaranController,
    PendaftaranClassController as AdminPendaftaranClassController,
    PendaftaranGuideController as AdminPendaftaranGuideController,
    PendaftaranLearnController as AdminPendaftaranLearnController
};

use App\Http\Controllers\Siswa\{
    PendaftaranController as SiswaPendaftaranController,
    DashboardController as SiswaDashboardController,
    StatusPendaftaranController
};

use App\Http\Controllers\Mentor\DashboardController as MentorDashboardController;

use App\Http\Controllers\Landing\PageController;
use App\Http\Controllers\Auth\{
    GoogleController,
    LoginController,
    RegisterController
};

use App\Http\Controllers\{
    PendaftaranProgramController,
    PendaftaranClassController,
    PendaftaranGuideController,
    PendaftaranLearnController
};

// ==========================
// ROOT & LANDING PAGE
// ==========================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PageController::class, 'home'])->name('landing.page.home');
Route::get('/about', [PageController::class, 'about'])->name('landing.page.about');
Route::get('/program', [PageController::class, 'program'])->name('landing.page.program');
Route::get('/program/{id}', [PageController::class, 'detailProgram'])->name('landing.page.detail-program');
Route::get('/team', [PageController::class, 'team'])->name('landing.page.team');
Route::get('/kontak', [PageController::class, 'kontak'])->name('landing.page.kontak');

// ==========================
// AUTH
// ==========================
Route::get('auth/google', [GoogleController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [RegisterController::class, 'register']);

// ==========================
// ADMIN ROUTES
// ==========================
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'jenis_kelas' => JenisKelasController::class,
        'mata_pelajaran' => MataPelajaranController::class,
        'jenjang_pendidikan' => JenjangPendidikanController::class,
        'paket_guide' => PaketGuideController::class,
        'kontak' => KontakController::class,
        'genze_learn' => GenzeLearnController::class,
        'jadwal_kelas' => JadwalKelasController::class,
        'jadwal_guide2' => JadwalGuide2Controller::class,
        'kategori_blog' => KategoriBlogController::class,
        'blog' => BlogController::class,
        'media-partners' => MediaPartnerController::class,
        'genze_guides' => GenzeGuideController::class,
        'promosi_class' => PromosiClassController::class,
        'mentor' => MentorController::class,
        'user' => UserController::class,
        'program' => ProgramController::class,
        'pembayaran' => AdminPendaftaranProgramController::class,
    ]);

    // Pendaftaran GenZE Class
    Route::prefix('pendaftaran/classes')->name('pendaftaran.classes.')->group(function () {
        Route::get('/data', [AdminPendaftaranClassController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPendaftaranClassController::class, 'show'])->name('show');
        Route::put('/{id}/konfirmasi', [AdminPendaftaranClassController::class, 'konfirmasiJadwal'])->name('konfirmasi');
    });

// Pendaftaran GenZE
Route::prefix('pendaftaran/guides')->name('pendaftaran.guides.')->group(function () {
    Route::get('/data', [AdminPendaftaranGuideController::class, 'index'])->name('index');
    Route::get('/{id}', [AdminPendaftaranGuideController::class, 'show'])->name('show');
    Route::post('/{id}/konfirmasi', [AdminPendaftaranGuideController::class, 'konfirmasiJadwal'])->name('konfirmasi');
});


Route::prefix('pendaftaran/learns')->name('pendaftaran.learns.')->group(function () {
    Route::get('/data', [AdminPendaftaranLearnController::class, 'index'])->name('index');
    Route::get('/{id}', [AdminPendaftaranLearnController::class, 'show'])->name('show');

    // Ubah konfirmasi jadi verifikasi pembayaran
    Route::post('/{id}/verifikasi', [AdminPendaftaranLearnController::class, 'verifikasiPembayaran'])->name('verifikasi');

    // Tambah route upload sertifikat
    Route::post('/{id}/upload-sertifikat', [AdminPendaftaranLearnController::class, 'uploadSertifikat'])->name('uploadSertifikat');
});



    // Tambahan admin untuk verifikasi pendaftaran umum (opsional)
    Route::get('/pendaftarann', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftarann/{id}', [PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftarann/{id}/konfirmasi-jadwal', [PendaftaranController::class, 'konfirmasiJadwal'])->name('pendaftaran.konfirmasiJadwal');
    Route::get('/pendaftarann/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'showVerifikasiPembayaranForm'])->name('pendaftaran.showVerifikasiPembayaranForm');
    Route::post('/pendaftarann/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'verifikasiPembayaran'])->name('pendaftaran.verifikasiPembayaran');
});

// ==========================
// MENTOR ROUTES
// ==========================
Route::prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');
});

// ==========================
// SISWA ROUTES
// ==========================
Route::prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    Route::get('/pendaftaran', [SiswaPendaftaranController::class, 'create'])->name('pendaftaran.form');
    Route::post('/pendaftaran', [SiswaPendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/email/{id}', [SiswaPendaftaranController::class, 'formEmail'])->name('pendaftaran.formEmail');
    Route::post('/pendaftaran/dashboard/{id}', [SiswaPendaftaranController::class, 'dashboard'])->name('pendaftaran.dashboard');
    Route::get('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadForm'])->name('pendaftaran.uploadForm');
    Route::post('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadBukti'])->name('pendaftaran.uploadBukti');

    // GenZE Class
    Route::prefix('pendaftaran/genze-class')->name('pendaftaran.genze-class.')->group(function () {
        Route::get('/', [PendaftaranClassController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranClassController::class, 'store'])->name('store');
    });

    // GenZE Guide
    Route::prefix('pendaftaran/genze-guide')->name('pendaftaran.genze-guide.')->group(function () {
        Route::get('/', [PendaftaranGuideController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranGuideController::class, 'store'])->name('store');
    });

    // Status Pendaftaran
    Route::get('/pendaftaran/status/{id}', function ($id) {
        $pendaftaran = \App\Models\PendaftaranProgram::with('pendaftaranClass.jadwalKonfirmasi')->findOrFail($id);
        return view('siswa.pendaftaran.status', compact('pendaftaran'));
    })->name('pendaftaran.status');
});



// ==========================
// PENDAFTARAN UMUM
// // ==========================
// Route::get('/pendaftaran-guide/create/{program_id}', [PendaftaranGuideController::class, 'create'])->name('pendaftaran-guide.create');

// Route::post('/pendaftaran/store', [PendaftaranProgramController::class, 'store'])->name('pendaftaran.program.store');
// Route::post('/siswa/pendaftaran/upload/{id}', [PendaftaranProgramController::class, 'uploadBukti'])->name('siswa.pendaftaran.upload');

// Mata Pelajaran berdasarkan Jenjang
Route::get('/mata-pelajaran/by-jenjang/{id}', [PendaftaranClassController::class, 'mataPelajaranByJenjang'])->name('mata-pelajaran.by-jenjang');


Route::prefix('pendaftaran-guide')->group(function () {
    // Halaman pendaftaran guide (tanpa program_id di URL)
    Route::get('/create', [PendaftaranGuideController::class, 'create'])->name('pendaftaran-guide.create');

    // Store data pendaftaran guide
    Route::post('/store', [PendaftaranGuideController::class, 'store'])->name('pendaftaran-guide.store');

    // Halaman form email setelah pendaftaran
    Route::get('/form-email/{id}', [PendaftaranGuideController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');

    // Ambil jadwal guide berdasarkan paket
    Route::get('/jadwal-guide/{id}', [PendaftaranGuideController::class, 'jadwalGuide2ByPaket'])->name('pendaftaran-guide.jadwal');

});



// routes/web.php


// Halaman Form Pendaftaran GenZE Learn
Route::get('/pendaftaran-learn/{program_id}', [PendaftaranLearnController::class, 'create'])
    ->name('pendaftaran-learn.create');

// Proses Penyimpanan Pendaftaran Learn
Route::post('/pendaftaran-learn/store', [PendaftaranLearnController::class, 'store'])
    ->name('pendaftaran-learn.store');

// Form Email setelah pendaftaran berhasil
Route::get('/pendaftaran-learn/form-email/{id}', [PendaftaranLearnController::class, 'formEmail'])
    ->name('siswa.pendaftaran.formEmail');

// Upload Sertifikat oleh Admin
Route::post('/pendaftaran-learn/upload-sertifikat/{id}', [PendaftaranLearnController::class, 'uploadSertifikat'])
    ->name('pendaftaran-learn.uploadSertifikat');


    use App\Http\Controllers\Siswa\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

use App\Http\Controllers\MidtransWebhookController;

Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);


