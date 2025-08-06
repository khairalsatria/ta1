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
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar_soal')) {
            $path = $request->file('gambar_soal')->store('soal_gambar', 'public');
            $data['gambar_soal'] = $path;
        }

        SoalLatihan::create($data);

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

    public function kelasIndex()
{
    $kelasList = KelasGenze::where('mentor_id', Auth::id())->get();

    return view('mentor.soal.kelas-index', compact('kelasList'));
}


    public function index($kelas_id, $pertemuan_ke)
{
    $kelas = KelasGenze::where('mentor_id', Auth::id())->findOrFail($kelas_id);
    $soalList = SoalLatihan::where('kelas_id', $kelas_id)
                ->where('pertemuan_ke', $pertemuan_ke)
                ->get();

    return view('mentor.soal.index', compact('kelas', 'pertemuan_ke', 'soalList'));
}

public function edit($id)
{
    $soal = SoalLatihan::findOrFail($id);

    // Pastikan soal milik mentor yang sedang login
    $kelas = KelasGenze::where('mentor_id', Auth::id())
                ->findOrFail($soal->kelas_id);

    return view('mentor.soal.edit', compact('soal', 'kelas'));
}

 public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'gambar_soal' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pilihan_a' => 'required|string',
            'pilihan_b' => 'required|string',
            'pilihan_c' => 'required|string',
            'pilihan_d' => 'required|string',
            'jawaban_benar' => 'required|in:a,b,c,d',
        ]);

        $soal = SoalLatihan::findOrFail($id);

        $data = $request->only([
            'pertanyaan',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'jawaban_benar',
        ]);

        if ($request->hasFile('gambar_soal')) {
            $path = $request->file('gambar_soal')->store('soal_gambar', 'public');
            $data['gambar_soal'] = $path;
        }

        $soal->update($data);

        return redirect()->route('mentor.soal.index', [
            'kelas_id' => $soal->kelas_id,
            'pertemuan_ke' => $soal->pertemuan_ke,
        ])->with('success', 'Soal berhasil diperbarui.');
    }


public function destroy($id)
{
    $soal = SoalLatihan::findOrFail($id);

    // Pastikan mentor yang menghapus adalah pemilik kelasnya
    $kelas = KelasGenze::where('mentor_id', Auth::id())->findOrFail($soal->kelas_id);

    $kelasId = $soal->kelas_id;
    $pertemuanKe = $soal->pertemuan_ke;

    $soal->delete();

    return redirect()->route('mentor.soal.index', [
        'kelas_id' => $kelasId,
        'pertemuan_ke' => $pertemuanKe,
    ])->with('success', 'Soal berhasil dihapus.');
}


}

