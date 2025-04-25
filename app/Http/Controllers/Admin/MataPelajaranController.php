<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    // Menampilkan semua mata_pelajaran
    public function index()
    {
        $mata_pelajaran = MataPelajaran::with('jenjangPendidikan')->get();
        return view('admin.mata_pelajaran.index', compact('mata_pelajaran'));
    }

    // Menampilkan form untuk menambah mata_pelajaran
    public function create()
    {
        $jenjangPendidikans = JenjangPendidikan::all();
        return view('admin.mata_pelajaran.create', compact('jenjangPendidikans'));
    }

    // Menyimpan mata_pelajaran baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'mata_pelajaran' => 'required|max:50',
            'jenjang_pendidikan' => 'required|exists:jenjang_pendidikans,id_jenjang_pendidikan', // Validasi untuk kolom pendidikan
        ]);

        // Menyimpan data mata_pelajaran
        MataPelajaran::create($request->all());

        return redirect()->route('admin.mata_pelajaran.index')
                         ->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit mata_pelajaran
    public function edit($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);
        $jenjangPendidikans = JenjangPendidikan::all();
        return view('admin.mata_pelajaran.edit', compact('mata_pelajaran', 'jenjangPendidikans'));
    }

    // Memperbarui data mata_pelajaran yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'mata_pelajaran' => 'required|max:50',
            'jenjang_pendidikan' => 'required|exists:jenjang_pendidikans,id_jenjang_pendidikan', // Validasi untuk kolom pendidikan
        ]);

        $mata_pelajaran = MataPelajaran::findOrFail($id);
        $mata_pelajaran->update($request->only('mata_pelajaran', 'jenjang_pendidikan')); // Menambahkan pendidikan

        return redirect()->route('admin.mata_pelajaran.index')
                         ->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    // Menghapus mata_pelajaran
    public function destroy($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);
        $mata_pelajaran->delete();

        return redirect()->route('admin.mata_pelajaran.index')
                         ->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
