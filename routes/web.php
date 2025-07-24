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
    KelasGenzeController,
    GenzeLearnEventController
};

use App\Http\Controllers\Siswa\{
    PendaftaranController as SiswaPendaftaranController,
    DashboardController as SiswaDashboardController,
    LatihanController,
    StatusPendaftaranController,
    MateriController as SiswaMateriController,
    ProfileController,
    ProgramSayaController,
    KelasSayaController,
    GuideController as SiswaGuideController,
    TestimonialController
};

use App\Http\Controllers\Mentor\{
    DashboardController as MentorDashboardController,
    MateriController as MentorMateriController,
    SoalController,
    KelasController as MentorKelasController
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
     Route::prefix('pendaftaran/guides')
            ->name('pendaftaran.guides.')
            ->group(function () {

                // LIST (index)
                // /admin/pendaftaran/guides/data
                Route::get('/data', [AdminPendaftaranGuideController::class, 'index'])
                    ->name('index');

                // DETAIL
                // /admin/pendaftaran/guides/{id}
                Route::get('/{id}', [AdminPendaftaranGuideController::class, 'show'])
                    ->whereNumber('id')
                    ->name('show');

                // KONFIRMASI JADWAL (paket 2)
                Route::post('/{id}/konfirmasi', [AdminPendaftaranGuideController::class, 'konfirmasiJadwal'])
                    ->whereNumber('id')
                    ->name('konfirmasi');

                // UPLOAD FILE HASIL (paket 1 & 3, status diterima)
                Route::post('/{id}/hasil', [AdminPendaftaranGuideController::class, 'uploadHasil'])
                    ->whereNumber('id')
                    ->name('uploadHasil');

                // SIMPAN LINK ZOOM (paket 2, setelah diterima & jadwal terkonfirmasi)
                Route::post('/{id}/zoom', [AdminPendaftaranGuideController::class, 'simpanZoom'])
                    ->whereNumber('id')
                    ->name('simpanZoom');

                // HAPUS FILE/LINK HASIL
                // /admin/pendaftaran/guides/hasil/{fileId}
                Route::delete('/hasil/{fileId}', [AdminPendaftaranGuideController::class, 'hapusHasil'])
                    ->whereNumber('fileId')
                    ->name('hapusHasil');
            });

    // Pendaftaran Learn
    Route::prefix('pendaftaran/learns')->name('pendaftaran.learns.')->group(function () {
        Route::get('/data', [AdminPendaftaranLearnController::class, 'index'])->name('index');
        Route::get('/{id}', [AdminPendaftaranLearnController::class, 'show'])->name('show');
        Route::post('/{id}/verifikasi', [AdminPendaftaranLearnController::class, 'verifikasiPembayaran'])->name('verifikasi');
        Route::post('/{id}/upload-sertifikat', [AdminPendaftaranLearnController::class, 'uploadSertifikat'])->name('uploadSertifikat');
    });

  Route::prefix('learn-events')->name('learn_events.')->group(function () {
    Route::get('/', [GenzeLearnEventController::class, 'index'])->name('index');
    Route::get('/{id}', [GenzeLearnEventController::class, 'show'])->name('show');
    Route::put('/{id}/update-zoom', [GenzeLearnEventController::class, 'updateZoom'])->name('updateZoom');
    Route::post('/{id}/upload-template', [GenzeLearnEventController::class, 'uploadTemplate'])->name('uploadTemplate');
    Route::post('/{id}/generate-sertifikat', [GenzeLearnEventController::class, 'generateMassal'])->name('generateMassal');
Route::post('/{id}/regenerate-sertifikat', [GenzeLearnEventController::class, 'regenerateMassal'])->name('regenerateMassal');
    // Route Preview Sertifikat
    Route::get('/{id}/preview-sertifikat', [GenzeLearnEventController::class, 'previewSertifikat'])
        ->name('previewSertifikat');
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
    Route::get('/program-saya', [ProgramSayaController::class, 'index'])->name('program-saya.index');
    Route::get('/kelas-saya', [KelasSayaController::class, 'index'])->name('kelas-saya');

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

     Route::get('/guide', [SiswaGuideController::class, 'index'])->name('guide.index');

 Route::get('/program-saya/learn', [\App\Http\Controllers\Siswa\LearnController::class, 'index'])
        ->name('program-saya.learn');
    Route::get('/program-saya/learn/{id}/sertifikat', [\App\Http\Controllers\Siswa\LearnController::class, 'downloadSertifikat'])
        ->name('program-saya.learn.sertifikat');
 Route::resource('testimonial', TestimonialController::class)->only(['index', 'create', 'store', 'destroy']);

    // Latihan
Route::prefix('latihan')->group(function () {

    // ✅ Per-soal (utama)
    Route::get('{kelas_id}/{pertemuan}/per-soal/{index?}', [LatihanController::class, 'showPerSoal'])
        ->name('latihan.show.per.soal');

    Route::post('{kelas_id}/{pertemuan}/per-soal/{index}', [LatihanController::class, 'submitPerSoal'])
        ->name('latihan.submit.per.soal');

    // (Opsional) Fallback legacy: kalau ada akses lama tanpa "per-soal"
    Route::get('{kelas_id}/{pertemuan}', [LatihanController::class, 'show'])
        ->name('latihan.show');
    Route::post('{kelas_id}/{pertemuan}', [LatihanController::class, 'submit'])
        ->name('latihan.submit');

        // Review soal per pertemuan
    Route::get('/kelas/{kelasId}/review/{pertemuanKe}', [LatihanController::class, 'review'])
        ->name('kelas.review');





});

});

// ==========================
// MENTOR ROUTES (Protected)
// ==========================
Route::middleware('auth')->prefix('mentor')->name('mentor.')->group(function () {
    Route::get('/dashboard', [MentorDashboardController::class, 'index'])->name('dashboard');

    // Materi
   Route::resource('/materi', MentorMateriController::class)->names('materi');


    // Soal
    Route::get('/kelas/{kelas_id}/soal/create', [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal', [SoalController::class, 'store'])->name('soal.store');

    // Daftar kelas & detail kelas
    Route::get('/kelas', [MentorKelasController::class, 'index'])->name('kelas.index');
    Route::get('/kelas/{id}', [MentorKelasController::class, 'show'])->name('kelas.show');

    Route::get('/kelas/{kelas}/siswa', [MentorKelasController::class, 'siswa'])
    ->name('kelas.siswa');

    Route::get('kelas/{kelas}/soal/{pertemuan}', [SoalController::class, 'detail'])
        ->name('kelas.soal.detail');
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



