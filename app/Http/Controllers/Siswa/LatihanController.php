<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SoalLatihan;
use App\Models\JawabanSoalLatihan;

class LatihanController extends Controller
{
    public function show($kelas_id, $pertemuan)
    {
        $soal = SoalLatihan::where('kelas_id', $kelas_id)
                ->where('pertemuan_ke', $pertemuan)
                ->get();

        return view('siswa.latihan.show', compact('soal', 'kelas_id', 'pertemuan'));
    }

    public function submit(Request $request, $kelas_id, $pertemuan)
    {
        $soal = SoalLatihan::where('kelas_id', $kelas_id)
                ->where('pertemuan_ke', $pertemuan)
                ->get();

        $benar = 0;
        foreach ($soal as $s) {
            $jawaban = $request->input('soal_' . $s->id);

            $isCorrect = ($jawaban == $s->jawaban_benar);
            if ($isCorrect) $benar++;

            JawabanSoalLatihan::create([
                'user_id' => Auth::id(),
                'soal_id' => $s->id,
                'jawaban_dipilih' => $jawaban,
                'benar' => $isCorrect
            ]);
        }

        $skor = round(($benar / max(count($soal), 1)) * 100);

        return redirect()->route('siswa.dashboard')->with('success', "Latihan selesai! Skor Anda: $skor");
    }
}

