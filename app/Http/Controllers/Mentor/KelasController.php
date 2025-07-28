<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\KelasGenze;
use App\Models\JawabanSoalLatihan;
use Carbon\Carbon;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with('program:id,nama_program')
            ->withCount(['siswa', 'materi'])
            ->get();

        return view('mentor.kelas.index', compact('kelas'));
    }

    public function show($id)
    {
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with([
                'program:id,nama_program',
                'materi' => fn($q) => $q->orderBy('pertemuan_ke', 'asc'),
            ])
            ->findOrFail($id);

        $totalPertemuan = 8;
        $pertemuanSudahDilakukan = $kelas->materi->whereNotNull('link_zoom')->count();
        $progress = $totalPertemuan > 0
            ? round(($pertemuanSudahDilakukan / $totalPertemuan) * 100)
            : 0;

        $materiBerikutnya = $kelas->materi
            ->filter(fn($m) => is_null($m->link_zoom))
            ->sortBy('pertemuan_ke')
            ->first();

        $materi = $kelas->materi;

        return view('mentor.kelas.show', compact(
            'kelas',
            'materi',
            'totalPertemuan',
            'pertemuanSudahDilakukan',
            'progress',
            'materiBerikutnya'
        ));
    }

    public function siswa(Request $request, $kelasId)
    {
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with([
                'program:id,nama_program',
                'materi:id,kelas_id,pertemuan_ke,link_zoom',
            ])
            ->withCount('siswa')
            ->findOrFail($kelasId);

        $materi = $kelas->materi->sortBy('pertemuan_ke')->values();
        $totalPertemuan = 8;
        $pertemuanSudahDilakukan = $materi->whereNotNull('link_zoom')->count();
        $pertemuanRange = range(1, $totalPertemuan);

        // Hanya siswa dengan status aktif
        $siswaQuery = $kelas->siswa()->where('status', 'aktif')->with([
            'pendaftaran.user:id,name,email',
        ]);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $siswaQuery->whereHas('pendaftaran.user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Auto update status ke 'selesai' jika progres 100%
        foreach ($kelas->siswa as $siswaKelas) {
            $materiCount = $materi->whereNotNull('link_zoom')->count();
            $progress = $materiCount > 0 ? round(($materiCount / 8) * 100) : 0;

            if ($progress >= 100 && $siswaKelas->status !== 'selesai') {
                $siswaKelas->update(['status' => 'selesai']);
            }
        }

        $siswaData = $siswaQuery->paginate(10)->appends($request->query());

        $userIds = $siswaData->getCollection()
            ->map(fn($p) => optional($p->pendaftaran)->user_id)
            ->filter()
            ->unique()
            ->values();

        $jawaban = collect();
        if ($userIds->isNotEmpty()) {
            $jawaban = JawabanSoalLatihan::with('soal:id,kelas_id,pertemuan_ke')
                ->whereIn('user_id', $userIds)
                ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasId))
                ->get()
                ->groupBy('user_id');
        }

        $transformed = $siswaData->getCollection()->map(function ($pendaftaranKelas) use (
            $jawaban,
            $pertemuanRange,
            $pertemuanSudahDilakukan,
            $totalPertemuan
        ) {
            $user = optional($pendaftaranKelas->pendaftaran)->user;
            if (!$user) {
                return null;
            }

            $jawabanUser = $jawaban->get($user->id, collect());

            $pertemuanScores = collect($pertemuanRange)->map(function ($pKe) use ($jawabanUser) {
                $jawabanPertemuan = $jawabanUser->filter(function ($j) use ($pKe) {
                    return optional($j->soal)->pertemuan_ke == $pKe;
                });

                $total = $jawabanPertemuan->count();
                $benar = $jawabanPertemuan->where('benar', 1)->count();
                $skor = $total ? round(($benar / $total) * 100) : null;

                return [
                    'pertemuan_ke' => $pKe,
                    'total'        => $total,
                    'benar'        => $benar,
                    'skor'         => $skor,
                ];
            });

            $progress = $totalPertemuan > 0
                ? round(($pertemuanSudahDilakukan / $totalPertemuan) * 100)
                : 0;

            return (object) [
                'user'               => $user,
                'progress'           => $progress,
                'pertemuan_selesai'  => $pertemuanSudahDilakukan,
                'total_pertemuan'    => $totalPertemuan,
                'pertemuan_scores'   => $pertemuanScores,
            ];
        })->filter()->values();

        $siswaData->setCollection($transformed);

        return view('mentor.kelas.siswa', compact(
            'kelas',
            'siswaData',
            'pertemuanRange',
            'totalPertemuan',
            'pertemuanSudahDilakukan'
        ));
    }
}
