<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\KelasGenze;
use App\Models\JawabanSoalLatihan;
use App\Models\SoalLatihan;
use Carbon\Carbon;

class KelasController extends Controller
{
    // -----------------------------
    // LIST KELAS
    // -----------------------------
    public function index()
    {
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with('program:id,nama_program')
            ->withCount(['siswa', 'materi'])
            ->get();

        return view('mentor.kelas.index', compact('kelas'));
    }

    // -----------------------------
    // DETAIL KELAS (materi & progres global)
    // -----------------------------
    public function show($id)
    {
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with([
                'program:id,nama_program',
                'materi' => fn($q) => $q->orderBy('pertemuan_ke', 'asc'),
            ])
            ->findOrFail($id);

        // Target tetap 8
        $totalPertemuan = 8;
        // Pertemuan dianggap berjalan bila materi punya link_zoom
        $pertemuanSudahDilakukan = $kelas->materi->whereNotNull('link_zoom')->count();
        $progress = $totalPertemuan > 0
            ? round(($pertemuanSudahDilakukan / $totalPertemuan) * 100)
            : 0;

        // Materi berikutnya: materi tanpa link_zoom? atau berdasarkan tanggal
        $materiBerikutnya = $kelas->materi
            ->filter(fn($m) => is_null($m->link_zoom)) // materi belum dijadwalkan zoom
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

    // -----------------------------
    // DAFTAR SISWA + PROGRES & SKOR PER PERTEMUAN (dengan search & pagination)
    // -----------------------------
    public function siswa(Request $request, $kelasId)
    {
        // Ambil data kelas milik mentor yang sedang login
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with([
                'program:id,nama_program',
                'materi:id,kelas_id,pertemuan_ke,link_zoom',
            ])
            ->withCount('siswa') // untuk $kelas->siswa_count di blade
            ->findOrFail($kelasId);

        // Materi / Pertemuan yang ada
        $materi = $kelas->materi->sortBy('pertemuan_ke')->values();

        // Target tetap 8 (fixed)
        $totalPertemuan = 8;

        // Pertemuan yang dianggap sudah dijalankan = materi punya link_zoom
        $pertemuanSudahDilakukan = $materi->whereNotNull('link_zoom')->count();

        // Range pertemuan yang akan ditampilkan (selalu 1..8 meski materi belum lengkap)
        $pertemuanRange = range(1, $totalPertemuan);

        // -----------------------------
        // Query relasi siswa (model yang mewakili keterdaftaran siswa di kelas ini)
        // Asumsi: relasi $kelas->siswa() -> hasMany(PendaftaranKelas / model sejenis)
        //         dan model tsb punya relasi `pendaftaran` -> PendaftaranProgram -> user()
        // -----------------------------
        $siswaQuery = $kelas->siswa()->with([
            'pendaftaran.user:id,name,email',
        ]);

        // Filter pencarian nama siswa (via relasi user)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $siswaQuery->whereHas('pendaftaran.user', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        // Pagination
        $siswaData = $siswaQuery->paginate(10)->appends($request->query());

        // -----------------------------
        // Ambil user_id siswa pada HALAMAN INI saja (hemat query)
        // -----------------------------
        $userIds = $siswaData->getCollection()
            ->map(fn($p) => optional($p->pendaftaran)->user_id)
            ->filter()
            ->unique()
            ->values();

        // Tarik jawaban semua siswa (hanya yg tampil di halaman ini) utk kelas ini + relasi soal (pertemuan_ke)
        $jawaban = collect();
        if ($userIds->isNotEmpty()) {
            $jawaban = JawabanSoalLatihan::with('soal:id,kelas_id,pertemuan_ke')
                ->whereIn('user_id', $userIds)
                ->whereHas('soal', fn($q) => $q->where('kelas_id', $kelasId))
                ->get()
                ->groupBy('user_id'); // group dulu per siswa
        }

        // -----------------------------
        // Transformasi item paginator -> struktur yang dipakai di Blade
        // -----------------------------
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

            // Hitung skor per pertemuan 1..8
            $pertemuanScores = collect($pertemuanRange)->map(function ($pKe) use ($jawabanUser) {
                $jawabanPertemuan = $jawabanUser->filter(function ($j) use ($pKe) {
                    return optional($j->soal)->pertemuan_ke == $pKe;
                });

                $total = $jawabanPertemuan->count();
                $benar = $jawabanPertemuan->where('benar', 1)->count(); // sesuaikan tipe kolom
                $skor = $total ? round(($benar / $total) * 100) : null;

                return [
                    'pertemuan_ke' => $pKe,
                    'total'        => $total,
                    'benar'        => $benar,
                    'skor'         => $skor,
                ];
            });

            // Progress global sama utk tiap siswa (kelas-based)
            $progress = $totalPertemuan > 0
                ? round(($pertemuanSudahDilakukan / $totalPertemuan) * 100)
                : 0;

            // Kembalikan object ringan utk Blade
            return (object) [
                'user'               => $user,
                'progress'           => $progress,
                'pertemuan_selesai'  => $pertemuanSudahDilakukan,
                'total_pertemuan'    => $totalPertemuan,
                'pertemuan_scores'   => $pertemuanScores,
            ];
        })->filter()->values();

        // Set koleksi hasil transformasi ke paginator
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

