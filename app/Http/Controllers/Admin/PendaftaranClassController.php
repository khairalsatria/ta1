<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;
use App\Models\PendaftaranClasses;
use App\Models\JadwalKelas;

class PendaftaranClassController extends Controller
{
    // Menampilkan semua pendaftaran class untuk admin
    public function index()
    {
        $pendaftaranClasses = PendaftaranClasses::with('pendaftaran.user', 'jadwalKonfirmasi')->get();
        return view('admin.pendaftaran.classes.index', compact('pendaftaranClasses'));
    }

    // Menampilkan detail dan form konfirmasi jadwal
    public function show($id)
    {
        $pendaftaranClass = PendaftaranClasses::with('pendaftaran.user')->findOrFail($id);
        $jadwalPilihan = $pendaftaranClass->jadwalPilihanObjects;
        return view('admin.pendaftaran.classes.show', compact('pendaftaranClass', 'jadwalPilihan'));
    }

    // Admin memilih jadwal yang dikonfirmasi
    public function konfirmasiJadwal(Request $request, $id)
    {

        $request->validate([
            'jadwal_konfirmasi' => 'required|exists:jadwal_kelas,id_jadwalkelas',
        ]);

        $pendaftaranClass = PendaftaranClasses::findOrFail($id);
        $pendaftaranClass->update([
            'jadwalkelas_konfirmasi' => $request->jadwal_konfirmasi,
        ]);

        return redirect()->route('admin.pendaftaran.classes.index')->with('success', 'Jadwal berhasil dikonfirmasi.');
    }
}
