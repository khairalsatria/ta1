<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\KelasGenze;

class DashboardController extends Controller
{
    public function index()
    {
        $mentorId = Auth::id();

        // Ambil kelas yang diampu mentor beserta relasi siswa dan materi
        $kelas = KelasGenze::where('mentor_id', $mentorId)
            ->with(['program:id,nama_program', 'siswa:id,kelas_id'])
            ->withCount(['materi'])
            ->get();

        // Total kelas diampu
        $totalKelasDiajar = $kelas->count();

        // Hitung jumlah siswa unik dari semua kelas
        $allSiswa = $kelas->pluck('siswa')->flatten();
        // Jika model siswa punya kolom 'user_id', gunakan itu, jika tidak gunakan 'id'
        $uniqueKey = $allSiswa->first() && isset($allSiswa->first()->user_id) ? 'user_id' : 'id';
        $totalSiswaDiajar = $allSiswa->unique($uniqueKey)->count();

        // Hitung total materi
        $totalMateriPertemuan = $kelas->sum('materi_count');

        return view('mentor.dashboard', compact(
            'kelas',
            'totalKelasDiajar',
            'totalSiswaDiajar',
            'totalMateriPertemuan'
        ));
    }
}
