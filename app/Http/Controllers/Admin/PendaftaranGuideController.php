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
        $pendaftarans = PendaftaranGuides::with(['pendaftaran.user', 'jadwalKonfirmasi'])->latest()->get();
        return view('admin.pendaftaran.guides.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranGuides::with(['pendaftaran.user', 'jadwalKonfirmasi'])->findOrFail($id);
        $jadwalTersedia = JadwalGuide2::all();
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

        // update status program menjadi bisa bayar
        $pendaftaran->pendaftaran->update(['status' => 'menunggu pembayaran']);

        return redirect()->route('admin.pendaftaran.guides.index')->with('success', 'Jadwal berhasil dikonfirmasi.');
    }
}
