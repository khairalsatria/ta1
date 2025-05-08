<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalKelas;
use Illuminate\Http\Request;

class JadwalKelasController extends Controller
{
    // Menampilkan semua jadwal kelas
    public function index()
    {
        $jadwal_kelas = JadwalKelas::all();
        return view('admin.jadwal_kelas.index', compact('jadwal_kelas'));
    }

    // Menampilkan form untuk menambah jadwal kelas
    public function create()
    {
        return view('admin.jadwal_kelas.create');
    }

    // Menyimpan jadwal kelas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required|array',
            'jam_mulai' => 'required|array',
            'jam_selesai' => 'required|array',
        ]);

        $jadwal = [];

        foreach ($request->hari as $hari) {
            $mulai = $request->jam_mulai[$hari] ?? null;
            $selesai = $request->jam_selesai[$hari] ?? null;

            if ($mulai && $selesai) {
                $mulaiFormatted = date('H.i', strtotime($mulai));
                $selesaiFormatted = date('H.i', strtotime($selesai));
                $jadwal[] = "{$hari} {$mulaiFormatted} - {$selesaiFormatted}";
            }
        }

        if (!empty($jadwal)) {
            JadwalKelas::create([
                'jadwalkelas' => implode(' & ', $jadwal)
            ]);
        }

        return redirect()->route('admin.jadwal_kelas.index')
                        ->with('success', 'Jadwal Kelas berhasil ditambahkan.');
    }




    // Menampilkan form untuk mengedit jadwal kelas
    public function edit($id)
{
    $jadwal_kelas = JadwalKelas::findOrFail($id);

    // Jika ingin menampilkan data terurai ke form, kamu bisa parsing data di sini
    // Namun jika hanya menampilkan form kosong dengan data lama, cukup ini:
    return view('admin.jadwal_kelas.edit', compact('jadwal_kelas'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'hari' => 'required|array',
        'jam_mulai' => 'required|array',
        'jam_selesai' => 'required|array',
    ]);

    $jadwal = [];

    foreach ($request->hari as $hari) {
        $mulai = $request->jam_mulai[$hari] ?? null;
        $selesai = $request->jam_selesai[$hari] ?? null;

        if ($mulai && $selesai) {
            $mulaiFormatted = date('H.i', strtotime($mulai));
            $selesaiFormatted = date('H.i', strtotime($selesai));
            $jadwal[] = "{$hari} {$mulaiFormatted} - {$selesaiFormatted}";
        }
    }

    $jadwal_kelas = JadwalKelas::findOrFail($id);

    if (!empty($jadwal)) {
        $jadwal_kelas->update([
            'jadwalkelas' => implode(' & ', $jadwal)
        ]);
    }

    return redirect()->route('admin.jadwal_kelas.index')
                     ->with('success', 'Jadwal Kelas berhasil diperbarui.');
}


    // Menghapus jadwal kelas
    public function destroy($id)
    {
        $jadwal_kelas = jadwalKelas::findOrFail($id);
        $jadwal_kelas->delete();

        return redirect()->route('admin.jadwal_kelas.index')
                         ->with('success', 'Jadwal Kelas berhasil dihapus.');
    }
}
