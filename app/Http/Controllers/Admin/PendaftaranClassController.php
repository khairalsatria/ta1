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
    $pendaftaranClasses = PendaftaranClasses::with([
        'pendaftaran.user',
        'jadwalKonfirmasi',
        'kelasGenze'
    ])->get();

    $daftar_kelas = KelasGenze::all();

    return view('admin.pendaftaran.classes.index', compact('pendaftaranClasses', 'daftar_kelas'));
}



    // Menampilkan detail dan form konfirmasi jadwal
    public function show($id)
{
    $pendaftaranClass = PendaftaranClasses::with('pendaftaran.user')->findOrFail($id);
    $jadwalPilihan = $pendaftaranClass->jadwalPilihanObjects;
    $daftar_kelas = KelasGenze::all(); // untuk dropdown pilih kelas
    $jadwalKelas = JadwalKelas::all(); // untuk dropdown konfirmasi jadwal

    return view('admin.pendaftaran.classes.show', compact(
        'pendaftaranClass', 'jadwalPilihan', 'daftar_kelas','jadwalKelas'
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

    return redirect()->route('admin.pendaftaran.classes.index', $id)
        ->with('success', 'Jadwal berhasil dikonfirmasi.');
}

public function tawarkanJadwalAlternatif(Request $request, $id)
{
    $request->validate([
        'jadwal_alternatif' => 'required|exists:jadwal_kelas,id_jadwalkelas',
    ]);

    $pendaftaran = PendaftaranClasses::findOrFail($id);
    $pendaftaran->update([
        'jadwalkelas_alternatif' => $request->jadwal_alternatif,
        'status_alternatif' => 'ditawarkan',
    ]);

    return redirect()->back()->with('success', 'Jadwal alternatif telah ditawarkan kepada siswa.');
}


public function assignKelas(Request $request, $id)
{
    $request->validate([
        'kelas_id' => 'required|exists:kelas_genze,id',
    ]);

    $pendaftaran = PendaftaranClasses::with('pendaftaran')->findOrFail($id);

    // Pastikan user_id tersedia via relasi
    if (!$pendaftaran->pendaftaran || !$pendaftaran->pendaftaran->user_id) {
        return redirect()->back()->with('error', 'User tidak ditemukan.');
    }

    $userId = $pendaftaran->pendaftaran->user_id;

    // Cek apakah user sudah tergabung dalam kelas yang sama
    $sudahTerdaftar = PendaftaranClasses::where('kelas_id', $request->kelas_id)
        ->whereHas('pendaftaran', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })
        ->exists();

    if ($sudahTerdaftar) {
        return redirect()->back()->with('error', 'Siswa sudah terdaftar di kelas ini.');
    }

    // Lanjutkan menetapkan kelas
    $pendaftaran->kelas_id = $request->kelas_id;
    $pendaftaran->save();

    return redirect()->route('admin.pendaftaran.classes.index')
        ->with('success', 'Kelas berhasil ditetapkan.');
}

public function destroy($id)
{
    $pendaftaranClass = PendaftaranClasses::with('pendaftaran')->findOrFail($id);

    if (!in_array($pendaftaranClass->pendaftaran->status, ['ditolak', 'menunggu'])) {
        return redirect()->route('admin.pendaftaran.classes.index')
            ->with('error', 'Pendaftaran hanya dapat dihapus jika statusnya ditolak atau menunggu.');
    }

    $pendaftaranClass->delete();

    return redirect()->route('admin.pendaftaran.classes.index')
        ->with('success', 'Pendaftaran berhasil dihapus.');
}



}
