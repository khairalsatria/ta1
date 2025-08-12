<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Landing\PageController;
use App\Http\Controllers\Auth\{GoogleController, LoginController, RegisterController,
    ForgotPasswordController, ResetPasswordController};
use App\Http\Controllers\{MidtransWebhookController,PendaftaranClassController, PendaftaranGuideController, PendaftaranLearnController};

use App\Http\Controllers\Admin\{
    JenisKelasController,
    DashboardController as AdminDashboardController,
    MataPelajaranController,
    JenjangPendidikanController,
    PaketGuideController,
    KontakController,
    KeuanganController,
    JadwalKelasController,
    JadwalGuide2Controller,
    KategoriBlogController,
    BlogController,
    MediaPartnerController,
    TestimonialController as AdminTestimonialController,
    FaqController,

    MentorController,
    UserController,
    ProgramController,
    PendaftaranProgramController as AdminPendaftaranProgramController,
    PendaftaranClassController as AdminPendaftaranClassController,
    PendaftaranGuideController as AdminPendaftaranGuideController,
    PendaftaranLearnController as AdminPendaftaranLearnController,
    KelasGenzeController,
    GenzeLearnEventController
};

use App\Http\Controllers\Siswa\{
    DashboardController as SiswaDashboardController,
    LatihanController,
    MateriController as SiswaMateriController,
    ProfileController,
    ProgramSayaController,
    KelasSayaController,
    GuideController as SiswaGuideController,
    TestimonialController,
    PendaftaranController
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
Route::get('/', function () {
    return redirect('/home');
});

Route::controller(PageController::class)->group(function () {
    Route::get('/home', 'home')->name('landing.page.home');
    Route::get('/about', 'about')->name('landing.page.about');
    Route::get('/program', 'program')->name('landing.page.program');
    Route::get('/program/{id}', 'detailProgram')->name('landing.page.detail-program');
    Route::get('/team', 'team')->name('landing.page.team');
    Route::get('/kontak', 'kontak')->name('landing.page.kontak');
    Route::get('/blog', 'blog')->name('landing.page.blog');
Route::get('/blog/{id}', 'detailBlog')->name('landing.page.detail-blog');




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
        'jadwal_kelas' => JadwalKelasController::class,
        'kelas' => KelasGenzeController::class, // ✅ SUDAH DI SINI
        'jadwal_guide2' => JadwalGuide2Controller::class,
        'kategori_blog' => KategoriBlogController::class,
        'blog' => BlogController::class,
        'media_partner' => MediaPartnerController::class,
        'mentor' => MentorController::class,
        'user' => UserController::class,
        'program' => ProgramController::class,
        'pembayaran' => AdminPendaftaranProgramController::class,
        'testimonial' => AdminTestimonialController::class,
        'faq' => FaqController::class,


    ]);
    Route::resource('keuangan', KeuanganController::class)->only([
    'index', 'create', 'store', 'edit', 'update', 'destroy'
]);

    Route::get('keuangan/cetak', [KeuanganController::class, 'cetak'])->name('keuangan.cetak');



    // Masukkan di sini:
    Route::post('/pendaftaran/{id}/assign-kelas', [AdminPendaftaranClassController::class, 'assignKelas'])->name('pendaftaran.assignKelas');



    // Pendaftaran Class
    Route::prefix('pendaftaran/classes')->name('pendaftaran.classes.')->group(function () {
        Route::get('/data', [AdminPendaftaranClassController::class, 'index'])->name('index');
        Route::delete('/{id}', [AdminPendaftaranClassController::class, 'destroy'])->name('destroy');
        Route::get('/{id}', [AdminPendaftaranClassController::class, 'show'])->name('show');
        Route::put('/{id}/konfirmasi', [AdminPendaftaranClassController::class, 'konfirmasiJadwal'])->name('konfirmasi');
        Route::post('{id}/alternatif', [AdminPendaftaranClassController::class, 'tawarkanJadwalAlternatif'])
    ->name('alternatif');


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

                // DELETE
Route::delete('/{id}', [AdminPendaftaranGuideController::class, 'destroy'])->name('destroy');
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
        Route::delete('/{id}', [AdminPendaftaranLearnController::class, 'destroy'])->name('destroy');
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





});

// ==========================
// SISWA ROUTES (Protected)
// ==========================
Route::middleware('auth')->prefix('siswa')->name('siswa.')->group(function () {
    Route::get('/status-pendaftaran', [PendaftaranController::class, 'riwayat'])->name('pendaftaran.riwayat');
Route::get('/status-pendaftaran/{id}', [PendaftaranController::class, 'status'])->name('pendaftaran.status');
    Route::get('/dashboard', [SiswaDashboardController::class, 'index'])->name('dashboard');

    // Pendaftaran Umum

    Route::get('/program-saya', [ProgramSayaController::class, 'index'])->name('program-saya.index');
    Route::get('/kelas-saya', [KelasSayaController::class, 'index'])->name('kelas-saya');

    // Pendaftaran GenZE Class
    Route::prefix('pendaftaran/genze-class')->name('pendaftaran.genze-class.')->group(function () {
        Route::get('/', [PendaftaranClassController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranClassController::class, 'store'])->name('store');
        Route::post('/respon-alternatif/{id}', [PendaftaranClassController::class, 'responAlternatif'])->name('responAlternatif');

    });

    // Pendaftaran GenZE Guide
    Route::prefix('pendaftaran/genze-guide')->name('pendaftaran.genze-guide.')->group(function () {
        Route::get('/', [PendaftaranGuideController::class, 'create'])->name('form');
        Route::post('/store', [PendaftaranGuideController::class, 'store'])->name('store');
    });



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

    Route::resource('/materi', MentorMateriController::class)->names('materi')->except(['show']);

// Soal
Route::get('/soal', [SoalController::class, 'kelasIndex'])->name('soal.kelas_index');

    Route::get('/kelas/{kelas_id}/pertemuan/{pertemuan_ke}/soal', [SoalController::class, 'index'])->name('soal.index');
    Route::get('/kelas/{kelas_id}/soal/create', [SoalController::class, 'create'])->name('soal.create');
    Route::post('/soal/store', [SoalController::class, 'store'])->name('soal.store');
    Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit');
    Route::put('/soal/{id}/update', [SoalController::class, 'update'])->name('soal.update');
    Route::delete('/soal/{id}/destroy', [SoalController::class, 'destroy'])->name('soal.destroy');


    // Detail jawaban dan rekap
    Route::get('/kelas/{kelas_id}/pertemuan/{pertemuan_ke}/soal/detail', [SoalController::class, 'detail'])->name('soal.detail');

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

// Halaman form lupa password
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
// Kirim email reset password
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Halaman form reset password (dari link email)
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
// Proses ganti password
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');





