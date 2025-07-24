<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MateriPertemuan;
use App\Models\JawabanSoalLatihan;
use App\Models\SoalLatihan;
use App\Models\KelasGenze;

class SoalController extends Controller
{
    public function create($kelas_id)
    {
        $kelas = KelasGenze::findOrFail($kelas_id);
        return view('mentor.soal.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_genze,id',
            'pertemuan_ke' => 'required|integer|min:1|max:8',
            'pertanyaan' => 'required|string',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        SoalLatihan::create($request->all());

        return redirect()->route('mentor.dashboard')->with('success', 'Soal berhasil ditambahkan.');
    }

   public function detail($kelasId, $pertemuanKe)
    {
        // Pastikan kelas milik mentor yang login
        $kelas = KelasGenze::where('mentor_id', Auth::id())
            ->with('program:id,nama_program')
            ->findOrFail($kelasId);

        // Ambil materi pertemuan ini (opsional; untuk judul & tanggal)
        $materi = MateriPertemuan::where('kelas_id', $kelasId)
            ->where('pertemuan_ke', $pertemuanKe)
            ->first(); // boleh null

        // Ambil semua soal utk kelas & pertemuan ini
        // (schema kamu tidak punya materi_id; gunakan kelas_id + pertemuan_ke)
        $soalList = SoalLatihan::where('kelas_id', $kelasId)
            ->where('pertemuan_ke', $pertemuanKe)
            ->with([
                // load jawaban + user yg menjawab
                'jawaban.user:id,name,email',
            ])
            ->get();

        // Kelompokkan jawaban per siswa supaya bisa rekap cepat
        $jawabanPerUser = JawabanSoalLatihan::with('user:id,name,email')
            ->whereHas('soal', function ($q) use ($kelasId, $pertemuanKe) {
                $q->where('kelas_id', $kelasId)
                  ->where('pertemuan_ke', $pertemuanKe);
            })
            ->get()
            ->groupBy('user_id');

        

        return view('mentor.kelas.detail-soal', compact(
            'kelas',
            'materi',
            'pertemuanKe',
            'soalList',
            'jawabanPerUser'
        ));
    }
}

