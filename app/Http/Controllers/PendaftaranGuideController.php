<?php

namespace App\Http\Controllers;

use App\Models\{
    PendaftaranProgram,
    PendaftaranGuides,
    Program,
    PaketGuide,
    JadwalGuide2
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranGuideController extends Controller
{
    public function create()
{
    // Ambil semua program yang tersedia
    $programs = Program::all();

    // Ambil data paket dan jadwal guide terkait
    $paketGuides = PaketGuide::all();
    $jadwalGuide2 = JadwalGuide2::all();

    return view('siswa.pendaftaran.genze-guide-form', compact('programs', 'paketGuides', 'jadwalGuide2'));
}


    public function store(Request $request)
    {
        // Validasi inputan berdasarkan paket yang dipilih
        $request->validate([
            'paket_guide' => 'required|integer',
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

        // Cek paket guide yang dipilih
        if ($request->paket_guide == 1 || $request->paket_guide == 3) {
            // Paket 1 dan 3 memerlukan upload file dan langsung bayar
            $request->validate([
                'file_upload' => 'required|file|mimes:pdf,doc,docx,jpg,png,jpeg',
            ]);

            // Buat entry untuk PendaftaranGuide dengan file upload
            PendaftaranGuides::create([
                'pendaftaran_id' => $pendaftaranProgram->id,
                'paket_guide' => $request->paket_guide,
                'file_upload' => $request->file('file_upload')->store('uploads/guide_files'), // menyimpan file upload
            ]);

            // Update status pendaftaran menjadi 'diterima' setelah file upload
            $pendaftaranProgram->update(['status' => 'diterima']);
        } elseif ($request->paket_guide == 2) {
            // Paket 2 memerlukan pilihan jadwal dan konfirmasi admin
            $request->validate([
                'jadwalguide2_pilihan' => 'required|array|max:3',
            ]);

            // Buat entry untuk PendaftaranGuide dengan jadwal pilihan
            PendaftaranGuides::create([
                'pendaftaran_id' => $pendaftaranProgram->id,
                'paket_guide' => $request->paket_guide,
                'jadwalguide2_pilihan' => $request->jadwalguide2_pilihan,
            ]);

            // Status masih menunggu konfirmasi admin
            $pendaftaranProgram->update(['status' => 'menunggu konfirmasi']);
        }

        return redirect()->route('siswa.pendaftaran.formEmail', $pendaftaranProgram->id)->with('success', 'Pendaftaran berhasil! Silakan cek email.');
    }

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }

    public function jadwalGuide2ByPaket($id)
    {
        // Mengambil jadwal guide berdasarkan paket yang dipilih
        return response()->json(JadwalGuide2::where('paket_guide_id', $id)->get());
    }
}
