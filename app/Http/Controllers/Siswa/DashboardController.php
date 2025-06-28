<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranClasses;
use App\Models\JawabanSoalLatihan;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil pendaftaran user dan materi dari kelas yang ditetapkan
        $pendaftaran = PendaftaranClasses::with('kelasGenze.materi')
            ->whereHas('pendaftaran', function ($q) {
                $q->where('user_id', Auth::id());
            })
            ->first();

        $materi = $pendaftaran?->kelasGenze?->materi ?? collect();

        // Ambil riwayat nilai latihan soal
        $riwayatNilai = JawabanSoalLatihan::with('soal')
            ->where('user_id', Auth::id())
            ->get()
            ->groupBy(fn($jawaban) => $jawaban->soal->pertemuan_ke);

        return view('siswa.dashboard', compact('materi', 'pendaftaran', 'riwayatNilai'));
    }
}
