<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranGuides;

class GuideController extends Controller
{
    /**
     * Menampilkan dashboard GenZE Guide untuk siswa.
     */
   public function index()
{
    $pendaftaranGuides = PendaftaranGuides::with([
        'pendaftaran',          // Relasi ke tabel pendaftaran_program
        'paketGuide',           // Relasi ke paket guide
        'jadwalKonfirmasi',     // Relasi jadwal konfirmasi untuk paket 2
        'hasilFiles.uploader',  // File hasil (dari admin)
    ])
    ->whereHas('pendaftaran', function ($q) {
        $q->where('user_id', Auth::id());
    })
    ->latest()
    ->paginate(6); // tampilkan 6 data per halaman

    return view('siswa.program-saya.guide', compact('pendaftaranGuides'));
}

}
