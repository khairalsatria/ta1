<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranGuides;
use App\Models\JadwalGuide2;
use App\Models\PendaftaranProgram;

class PendaftaranGuideController extends Controller
{
    public function index()
{
    $pendaftarans = PendaftaranGuides::with([
        'pendaftaran.user',
        'jadwalKonfirmasi',
        'paketGuide' // Tambahkan ini
    ])->latest()->get();

    return view('admin.pendaftaran.guides.index', compact('pendaftarans'));
}


        public function show($id)
    {
        $pendaftaran = PendaftaranGuides::with(['pendaftaran.user', 'jadwalKonfirmasi'])->findOrFail($id);

        // Ambil array ID jadwal yang sudah dipilih pendaftar
        $jadwalPilihanIds = $pendaftaran->jadwalguide2_pilihan ?? [];

        // Ambil jadwal yang sesuai ID pilihan
        $jadwalTersedia = JadwalGuide2::whereIn('id_jadwalguide2', $jadwalPilihanIds)->get();

        return view('admin.pendaftaran.guides.show', compact('pendaftaran', 'jadwalTersedia'));
    }


    public function konfirmasiJadwal(Request $request, $id)
    {
        $request->validate([
            'jadwalguide2_konfirmasi' => 'required|exists:jadwal_guide2,id_jadwalguide2',
        ]);

        $pendaftaran = PendaftaranGuides::findOrFail($id);
        $pendaftaran->jadwalguide2_konfirmasi = $request->jadwalguide2_konfirmasi;
        $pendaftaran->save();

        return redirect()->route('admin.pendaftaran.guides.index')->with('success', 'Jadwal berhasil dikonfirmasi.');
    }
}
