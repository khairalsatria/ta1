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
        $pendaftaranGuide = PendaftaranGuides::with([
            'pendaftaran',          // Relasi ke tabel pendaftaran_program
            'paketGuide',           // Relasi ke paket guide
            'jadwalKonfirmasi',     // Relasi jadwal konfirmasi untuk paket 2
            'hasilFiles.uploader',  // File hasil (dari admin)
        ])->whereHas('pendaftaran', function ($q) {
            $q->where('user_id', Auth::id());
        })->latest()->first();

        return view('siswa.program-saya.guide', compact('pendaftaranGuide'));
    }
}
