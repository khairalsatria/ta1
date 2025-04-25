<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JadwalGuide2;

class JadwalGuide2Controller extends Controller
{
    public function index()
    {
        $jadwal_guide2 = JadwalGuide2::all();
        return view('admin.jadwal_guide2.index', compact('jadwal_guide2'));
    }

    public function create()
    {
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        return view('admin.jadwal_guide2.create', compact('hariList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'hari' => 'required',
            'jam' => 'required|date_format:H:i',
        ]);

        $jamFormatted = date('H.i', strtotime($request->jam)) . ' WIB';
        $jadwalString = "{$request->hari}, {$jamFormatted}";

        JadwalGuide2::create([
            'jadwalguide2' => $jadwalString
        ]);

        return redirect()->route('admin.jadwal_guide2.index')->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $jadwal = JadwalGuide2::findOrFail($id);
        $hariList = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

        // Pisahkan hari dan jam dari jadwal seperti "Senin, 20.00 WIB"
        [$hari, $jamWib] = explode(', ', $jadwal->jadwalguide2);
        $jam = str_replace(['.',' WIB'], [':',''], $jamWib);

        return view('admin.jadwal_guide2.edit', compact('jadwal', 'hariList', 'hari', 'jam'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'hari' => 'required',
            'jam' => 'required|date_format:H:i',
        ]);

        $jamFormatted = date('H.i', strtotime($request->jam)) . ' WIB';
        $jadwalString = "{$request->hari}, {$jamFormatted}";

        $jadwal = JadwalGuide2::findOrFail($id);
        $jadwal->update([
            'jadwalguide2' => $jadwalString
        ]);

        return redirect()->route('admin.jadwal_guide2.index')->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $jadwal = JadwalGuide2::findOrFail($id);
        $jadwal->delete();

        return redirect()->route('admin.jadwal_guide2.index')->with('success', 'Jadwal berhasil dihapus.');
    }
}
