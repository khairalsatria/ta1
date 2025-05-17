<?php

namespace App\Http\Controllers;

use App\Models\{
    PendaftaranProgram,
    PendaftaranLearns,
    Program
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranLearnController extends Controller
{
    public function create($program_id)
    {
        $program = Program::findOrFail($program_id);
        $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();

        return view('landing.page.detail-program-learn', compact(
            'program', 'relatedPrograms'
        ));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'asal_instansi' => 'required|string|max:255',
            'tipe_program' => 'required|exists:programs,id',
        ]);

        // Ambil program terkait
        $program = Program::findOrFail($request->tipe_program);

        // Buat entry utama pendaftaran program
        $pendaftaranProgram = PendaftaranProgram::create([
            'user_id' => Auth::id(),
            'tipe_program' => $program->id,
            'harga' => $program->harga,
            'status' => 'menunggu', // status menunggu bukti pembayaran
        ]);

        // Buat entri detail Learn
        PendaftaranLearns::create([
            'pendaftaran_id' => $pendaftaranProgram->id,
            'asal_instansi' => $request->asal_instansi,
        ]);

        return redirect()->route('siswa.pendaftaran.formEmail', $pendaftaranProgram->id)
            ->with('success', 'Pendaftaran berhasil. Silakan upload bukti pembayaran.');
    }

    public function uploadSertifikat(Request $request, $id)
    {
        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf',
        ]);

        $filePath = $request->file('sertifikat')->store('sertifikat', 'public');

        $learn = PendaftaranLearns::findOrFail($id);
        $learn->update(['sertifikat' => $filePath]);

        return back()->with('success', 'Sertifikat berhasil diunggah.');
    }

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }
}
