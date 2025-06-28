<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;
use App\Models\PendaftaranClasses;
use App\Models\JadwalKelas;
use App\Models\KelasGenze; // Pastikan model KelasGenze sudah ada

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
    $daftar_kelas = KelasGenze::all(); // untuk dropdown pilih kelas

    return view('admin.pendaftaran.classes.show', compact(
        'pendaftaranClass', 'jadwalPilihan', 'daftar_kelas'
    ));
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

    return redirect()->route('admin.pendaftaran.classes.show', $id)
        ->with('success', 'Jadwal berhasil dikonfirmasi.');
}

public function assignKelas(Request $request, $id)
{
    $request->validate([
        'kelas_id' => 'required|exists:kelas_genze,id'
    ]);

    $pendaftaran = PendaftaranClasses::findOrFail($id);
    $pendaftaran->kelas_id = $request->kelas_id;
    $pendaftaran->save();

    return redirect()->route('admin.pendaftaran.classes.show', $id)
        ->with('success', 'Kelas berhasil ditetapkan.');
}

}
