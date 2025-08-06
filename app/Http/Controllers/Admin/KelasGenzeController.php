<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KelasGenze;
use App\Models\Program;
use App\Models\JadwalKelas;
use App\Models\User;
use Illuminate\Http\Request;

class KelasGenzeController extends Controller
{
    public function index()
    {
        $kelas = KelasGenze::with('mentor', 'siswa')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    public function create()
{
    $mentors = User::where('role', 'mentor')->get();
    $programs = Program::all();
    $jadwal_kelas = JadwalKelas::all();
    return view('admin.kelas.create', compact('mentors', 'programs', 'jadwal_kelas'));
}

    public function store(Request $request)
    {
       $request->validate([
    'nama_kelas' => 'required|string|max:255',
    'program_id' => 'required|exists:programs,id',
    'mentor_id' => 'nullable|exists:users,id',
    'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id_jadwalkelas',
    'kuota' => 'required|integer|min:1',
    'deskripsi' => 'nullable|string',
    'link_zoom_default' => 'nullable|url',
]);


        KelasGenze::create($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dibuat.');
    }

    public function edit($id)
{
    $kelas = KelasGenze::findOrFail($id);
    $mentors = User::where('role', 'mentor')->get();
    $programs = Program::all();
    $jadwal_kelas = JadwalKelas::all();
    return view('admin.kelas.edit', compact('kelas', 'mentors', 'programs', 'jadwal_kelas'));
}


    public function update(Request $request, $id)
    {
        $request->validate([
    'nama_kelas' => 'required|string|max:255',
    'program_id' => 'required|exists:programs,id',
    'mentor_id' => 'nullable|exists:users,id',
    'jadwal_kelas_id' => 'required|exists:jadwal_kelas,id_jadwalkelas',
    'kuota' => 'required|integer|min:1',
    'deskripsi' => 'nullable|string',
    'link_zoom_default' => 'nullable|url',
]);


        $kelas = KelasGenze::findOrFail($id);
        $kelas->update($request->all());
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kelas = KelasGenze::findOrFail($id);
        $kelas->delete();
        return redirect()->route('admin.kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
