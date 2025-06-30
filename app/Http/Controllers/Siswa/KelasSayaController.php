<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PendaftaranClasses;
use App\Models\JawabanSoalLatihan;
use App\Models\SoalLatihan;

class KelasSayaController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        // Ambil semua kelas yang diikuti siswa
        $kelasList = PendaftaranClasses::with('kelasGenze')
            ->whereHas('pendaftaran', fn($q) => $q->where('user_id', $user->id))
            ->get();

        $kelasDipilihId = $request->get('kelas_id');

        $materi = collect();
        $riwayatNilai = collect();

        if ($kelasDipilihId) {
            $kelas = $kelasList->firstWhere('kelas_id', $kelasDipilihId);

            // Materi dari kelas yang dipilih
            $materi = $kelas?->kelasGenze?->materi ?? collect();

            // Nilai latihan hanya untuk kelas yang dipilih
            $riwayatNilai = JawabanSoalLatihan::with('soal')
                ->where('user_id', $user->id)
                ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasDipilihId))
                ->get()
                ->groupBy(fn($j) => $j->soal->pertemuan_ke);
        }

        $totalPertemuan = 8; // Tetap: target 8 pertemuan per bulan
$pertemuanSudahDilakukan = $materi->whereNotNull('link_zoom')->count();

$progress = round(($pertemuanSudahDilakukan / $totalPertemuan) * 100);

$materiBerikutnya = $materi
    ->where('tanggal_pertemuan', '>', now())
    ->sortBy('tanggal_pertemuan')
    ->first();


return view('siswa.kelas-saya', compact(
    'kelasList', 'materi', 'riwayatNilai', 'kelasDipilihId',
    'progress', 'pertemuanSudahDilakukan', 'totalPertemuan',
    'materiBerikutnya'
));




    }
}
