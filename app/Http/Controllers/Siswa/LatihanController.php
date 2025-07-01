<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\SoalLatihan;
use App\Models\KelasGenze;
use App\Models\JawabanSoalLatihan;

class LatihanController extends Controller
{
    // Menampilkan satu soal per halaman
    public function showPerSoal($kelas_id, $pertemuan, $index = 0)
    {
        $soal = SoalLatihan::where('kelas_id', $kelas_id)
            ->where('pertemuan_ke', $pertemuan)
            ->get();

        $kelas_nama = KelasGenze::where('id', $kelas_id)->value('nama_kelas');

        if ($index >= count($soal)) {
            return redirect()->route('siswa.kelas-saya')->with('error', 'Soal tidak ditemukan.');
        }

        $currentSoal = $soal[$index];

        return view('siswa.latihan.show_per_soal', compact(
            'currentSoal', 'kelas_id', 'pertemuan', 'kelas_nama', 'index', 'soal'
        ));
    }

    // Menyimpan jawaban soal per index
    public function submitPerSoal(Request $request, $kelas_id, $pertemuan, $index)
    {
        $soal = SoalLatihan::where('kelas_id', $kelas_id)
            ->where('pertemuan_ke', $pertemuan)
            ->get();

        $currentSoal = $soal[$index] ?? null;

        if (!$currentSoal) {
            return redirect()->route('siswa.kelas-saya')->with('error', 'Soal tidak ditemukan.');
        }

        $jawaban = $request->input('jawaban');
        $isCorrect = ($jawaban == $currentSoal->jawaban_benar);

        JawabanSoalLatihan::updateOrCreate(
            ['user_id' => Auth::id(), 'soal_id' => $currentSoal->id],
            ['jawaban_dipilih' => $jawaban, 'benar' => $isCorrect]
        );

        if ($index + 1 >= count($soal)) {
            return redirect()->route('siswa.kelas-saya')->with('success', 'Latihan selesai! Silakan lihat skor Anda.');
        }

        return redirect()->route('siswa.latihan.show.per.soal', [$kelas_id, $pertemuan, $index + 1]);
    }
}
