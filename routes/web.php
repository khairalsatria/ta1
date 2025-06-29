<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\PageController;
use App\Http\Controllers\Auth\{GoogleController, LoginController, RegisterController};
use App\Http\Controllers\{MidtransWebhookController, PendaftaranProgramController, PendaftaranClassController, PendaftaranGuideController, PendaftaranLearnController};

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
    PendaftaranLearnController as AdminPendaftaranLearnController,
    KelasGenzeController
};

use App\Http\Controllers\Siswa\{
    PendaftaranController as SiswaPendaftaranController,
    DashboardController as SiswaDashboardController,
    LatihanController,
    StatusPendaftaranController,
    MateriController as SiswaMateriController,
    ProfileController
};

use App\Http\Controllers\Mentor\{
    DashboardController as MentorDashboardController,
    MateriController as MentorMateriController,
    SoalController
};

// ==========================
// LANDING PAGE
// ==========================
Route::get('/', fn() => view('welcome'));
Route::controller(PageController::class)->group(function () {
    Route::get('/home', 'home')->name('landing.page.home');
    Route::get('/about', 'about')->name('landing.page.about');
    Route::get('/program', 'program')->name('landing.page.program');
    Route::get('/program/{id}', 'detailProgram')->name('landing.page.detail-program');
    Route::get('/team', 'team')->name('landing.page.team');
    Route::get('/kontak', 'kontak')->name('landing.page.kontak');
});

// ==========================
// AUTHENTICATION
// ==========================
Route::controller(GoogleController::class)->group(function () {
    Route::get('auth/google', 'redirectToGoogle')->name('google.login');
    Route::get('auth/google/callback', 'handleGoogleCallback');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'showLoginForm')->name('login');
    Route::post('login', 'login');
    Route::post('logout', 'logout')->name('logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'showRegistrationForm')->name('register');
    Route::post('register', 'register');
});

// ==========================
// ADMIN ROUTES (Protected)
// ==========================
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resources([
        'jenis_kelas' => JenisKelasController::class,
        'mata_pelajaran' => MataPelajaranController::class,
        'jenjang_pendidikan' => JenjangPendidikanController::class,
        'paket_guide' => PaketGuideController::class,
        'kontak' => KontakController::class,
        'genze_learn' => GenzeLearnController::class,
        'jadwal_kelas' => JadwalKelasController::class,
        'kelas' => KelasGenzeController::class, // ✅ SUDAH DI SINI
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

    // Masukkan di sini:
    Route::post('/pendaftaran/{id}/assign-kelas', [AdminPendaftaranClassController::class, 'assignKelas'])->name('pendaftaran.assignKelas');



    // Pendaftaran Class
    Route::prefix('pendaftaran/classes')->name('pendaftaran.classes.')->group(function () {
        Route::get('/data', [AdminPendaftaranClassController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPendaftaranClassController::class, 'show'])->name('show');
        Route::put('/{id}/konfirmasi', [AdminPendaftaranClassController::class, 'konfirmasiJadwal'])->name('konfirmasi');
        // Route::post('/pendaftaran/{id}/assign-kelas', [AdminPendaftaranClassController::class, 'assignKelas'])->name('assignKelas');
    });

    // Pendaftaran Guide
    Route::prefix('pendaftaran/guides')->name('pendaftaran.guides.')->group(function () {
        Route::get('/data', [AdminPendaftaranGuideController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPendaftaranGuideController::class, 'show'])->name('show');
        Route::post('/{id}/konfirmasi', [AdminPendaftaranGuideController::class, 'konfirmasiJadwal'])->name('konfirmasi');
    });

    // Pendaftaran Learn
    Route::prefix('pendaftaran/learns')->name('pendaftaran.learns.')->group(function () {
        Route::get('/data', [AdminPendaftaranLearnController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPendaftaranLearnController::class, 'show'])->name('show');
        Route::post('/{id}/verifikasi', [AdminPendaftaranLearnController::class, 'verifikasiPembayaran'])->name('verifikasi');
        Route::post('/{id}/upload-sertifikat', [AdminPendaftaranLearnController::class, 'uploadSertifikat'])->name('uploadSertifikat');
    });

    // Pendaftaran Program Umum
    Route::prefix('pendaftarann')->name('pendaftaran.')->group(function () {
        Route::get('/', [PendaftaranController::class, 'index'])->name('index');
        Route::get('/{id}', [PendaftaranController::class, 'show'])->name('show');
        Route::post('/{id}/konfirmasi-jadwal', [PendaftaranController::class, 'konfirmasiJadwal'])->name('konfirmasiJadwal');
        Route::get('/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'showVerifikasiPembayaranForm'])->name('showVerifikasiPembayaranForm');
        Route::post('/{id}/verifikasi-pembayaran', [PendaftaranController::class, 'verifikasiPembayaran'])->name('verifikasiPembayaran');
    });


});

// ==========================
// SISWA ROUTES (Protected)
// ==========================
Route::middleware('auth')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran Umum
    Route::get('/pendaftaran', [SiswaPendaftaranController::class, 'create'])->name('pendaftaran.form');
    Route::post('/pendaftaran', [SiswaPendaftaranController::class, 'store'])->name('pendaftaran.store');
    Route::get('/pendaftaran/email/{id}', [SiswaPendaftaranController::class, 'formEmail'])->name('pendaftaran.formEmail');
    Route::post('/pendaftaran/dashboard/{id}', [SiswaPendaftaranController::class, 'dashboard'])->name('pendaftaran.dashboard');
    Route::get('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadForm'])->name('pendaftaran.uploadForm');
    Route::post('/pendaftaran/upload/{id}', [SiswaPendaftaranController::class, 'uploadBukti'])->name('pendaftaran.uploadBukti');

    // Pendaftaran GenZE Class
    Route::prefix('pendaftaran/genze-class')->name('pendaftaran.genze-class.')->group(function () {
        Route::get('/', [PendaftaranClassController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranClassController::class, 'store'])->name('store');
    });

    // Pendaftaran GenZE Guide
    Route::prefix('pendaftaran/genze-guide')->name('pendaftaran.genze-guide.')->group(function () {
        Route::get('/', [PendaftaranGuideController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranGuideController::class, 'store'])->name('store');
    });

    // Status Pendaftaran
    Route::get('/pendaftaran/status/{id}', function ($id) {
        $pendaftaran = \App\Models\PendaftaranProgram::with('pendaftaranClass.jadwalKonfirmasi')->findOrFail($id);
        return view('siswa.pendaftaran.status', compact('pendaftaran'));
    })->name('pendaftaran.status');

    // Materi
    Route::get('/materi', [SiswaMateriController::class, 'index'])->name('materi.index');

    // Latihan
    Route::get('/latihan/{kelas_id}/{pertemuan}', [LatihanController::class, 'show'])->name('latihan.show');
    Route::post('/latihan/{kelas_id}/{pertemuan}', [LatihanController::class, 'submit'])->name('latihan.submit');
});

// ==========================
// MENTOR ROUTES (Protected)
// ==========================
Route::middleware('auth')->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');

    // Materi
    Route::get('/materi/create/{kelas_id}', [MentorMateriController::class, 'create'])->name('materi.create');
    Route::post('/materi', [MentorMateriController::class, 'store'])->name('materi.store');

    // Soal
    Route::get('/kelas/{kelas_id}/soal/create', [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal', [SoalController::class, 'store'])->name('soal.store');
});

// ==========================
// PENDAFTARAN GENZE (UMUM)
// ==========================
Route::get('/pendaftaran-learn/{program_id}', [PendaftaranLearnController::class, 'create'])->name('pendaftaran-learn.create');
Route::post('/pendaftaran-learn/store', [PendaftaranLearnController::class, 'store'])->name('pendaftaran-learn.store');
Route::get('/pendaftaran-learn/form-email/{id}', [PendaftaranLearnController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');
Route::post('/pendaftaran-learn/upload-sertifikat/{id}', [PendaftaranLearnController::class, 'uploadSertifikat'])->name('pendaftaran-learn.uploadSertifikat');

// Pendaftaran Guide Umum
Route::prefix('pendaftaran-guide')->group(function () {
    Route::get('/create', [PendaftaranGuideController::class, 'create'])->name('pendaftaran-guide.create');
    Route::post('/store', [PendaftaranGuideController::class, 'store'])->name('pendaftaran-guide.store');
    Route::get('/form-email/{id}', [PendaftaranGuideController::class, 'formEmail'])->name('siswa.pendaftaran.formEmail');
    Route::get('/jadwal-guide/{id}', [PendaftaranGuideController::class, 'jadwalGuide2ByPaket'])->name('pendaftaran-guide.jadwal');
});

// Mata Pelajaran by Jenjang
Route::get('/mata-pelajaran/by-jenjang/{id}', [PendaftaranClassController::class, 'mataPelajaranByJenjang'])->name('mata-pelajaran.by-jenjang');

// ==========================
// PROFILE SISWA
// ==========================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// ==========================
// WEBHOOK (Midtrans)
// ==========================
Route::post('/midtrans/webhook', [MidtransWebhookController::class, 'handle']);

// Route::prefix('admin')->name('admin.')->group(function () {
//     Route::resource('kelas', KelasGenzeController::class);
//     Route::post('/pendaftaran/{id}/assign-kelas', [AdminPendaftaranClassController::class, 'assignKelas'])->name('pendaftaran.assignKelas');
// });
