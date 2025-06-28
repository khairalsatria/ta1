<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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
}

