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

   $kelasList = PendaftaranClasses::with('kelasGenze.jadwalKelas')

        ->whereHas('pendaftaran', fn($q) => $q->where('user_id', $user->id))
        ->get();

    $kelasDipilihId = $request->get('kelas_id');
    $materi = collect();
    $riwayatNilai = collect();
    $progress = 0;
    $pertemuanSudahDilakukan = 0;
    $totalPertemuan = 8;
    $materiBerikutnya = null;
    $statusKelas = null;

    if ($kelasDipilihId) {
        $kelas = $kelasList->firstWhere('kelas_id', $kelasDipilihId);
        $statusKelas = $kelas?->status;

        if ($statusKelas === 'aktif') {
            $materi = $kelas?->kelasGenze?->materi ?? collect();

            $pertemuanSudahDilakukan = $materi->whereNotNull('link_zoom')->count();
            $progress = round(($pertemuanSudahDilakukan / $totalPertemuan) * 100);

            $materiBerikutnya = $materi
                ->where('tanggal_pertemuan', '>', now())
                ->sortBy('tanggal_pertemuan')
                ->first();

            $riwayatNilai = JawabanSoalLatihan::with('soal')
                ->where('user_id', $user->id)
                ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasDipilihId))
                ->get()
                ->groupBy(fn($j) => $j->soal->pertemuan_ke);
        }
    }

    return view('siswa.kelas-saya', compact(
        'kelasList', 'materi', 'riwayatNilai', 'kelasDipilihId',
        'progress', 'pertemuanSudahDilakukan', 'totalPertemuan',
        'materiBerikutnya', 'statusKelas'
    ));
}

}
