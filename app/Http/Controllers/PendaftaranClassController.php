<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{
    PendaftaranProgram,
    PendaftaranClasses,
    JenisKelas,
    JenjangPendidikan,
    MataPelajaran,
    JadwalKelas,
    Program,
};
use Illuminate\Support\Facades\Auth;

class PendaftaranClassController extends Controller
{
    public function create($program_id)
{
    $jenisKelas = JenisKelas::all();
    $jenjangPendidikans = JenjangPendidikan::all();
    $jadwalKelas = JadwalKelas::all();
    $program = Program::findOrFail($program_id); // Program ID bisa 1 atau 6
    // $program = Program::where('tipe_program', 'GenZE Class')->firstOrFail();
    $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();
    return view('landing.page.detail-program', compact(
        'jenisKelas',
        'jenjangPendidikans',
        'jadwalKelas',
        'program',
        'relatedPrograms'
    ));
}





    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pilihan' => 'required|array|max:3',
            'id_jeniskelas' => 'required|integer',
            'kelas' => 'required|string',
            'id_jenjang_pendidikan' => 'required|integer',
            'id_mata_pelajaran' => 'required|integer',
        ]);

       // Ambil data program
    $program = Program::findOrFail($request->tipe_program);

    // Buat entry utama pendaftaran program
    $pendaftaranProgram = PendaftaranProgram::create([
        'user_id' => Auth::id(),
        'tipe_program' => $program->id,
        'harga' => $program->harga,
        'status' => 'menunggu',
    ]);

        // Buat entry detail untuk genze class (pendaftaran_classes)
        PendaftaranClasses::create([
            'pendaftaran_id' => $pendaftaranProgram->id,
            'jeniskelas' => $request->id_jeniskelas,
            'kelas' => $request->kelas,
            'jenjang_pendidikan' => $request->id_jenjang_pendidikan,
            'mata_pelajaran' => $request->id_mata_pelajaran,
            'jadwalkelas_pilihan' => $request->jadwal_pilihan,
        ]);

        return redirect()->route('siswa.pendaftaran.formEmail', $pendaftaranProgram->id)->with('success', 'Pendaftaran berhasil! Silakan cek email.');
    }

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }

    public function mataPelajaranByJenjang($id)
    {
        return response()->json(MataPelajaran::where('jenjang_pendidikan', $id)->get());
    }
}
