<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisKelas;
use Illuminate\Http\Request;

class JenisKelasController extends Controller
{
    // Menampilkan semua jenis kelas
    public function index()
    {
        $jenis_kelas = JenisKelas::all();
        return view('admin.jenis_kelas.index', compact('jenis_kelas'));
    }

    // Menampilkan form untuk menambah jenis kelas
    public function create()
    {
        return view('admin.jenis_kelas.create');
    }

    // Menyimpan jenis kelas baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'jeniskelas' => 'required|max:50',
        ]);

        // Menyimpan data jenis kelas
        JenisKelas::create($request->all());

        return redirect()->route('admin.jenis_kelas.index')
                         ->with('success', 'Jenis Kelas berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit jenis kelas
    public function edit($id)
    {
        $jenis_kelas = JenisKelas::findOrFail($id);
        return view('admin.jenis_kelas.edit', compact('jenis_kelas'));
    }

    // Memperbarui data jenis kelas yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'jeniskelas' => 'required|max:50',
        ]);

        $jenis_kelas = JenisKelas::findOrFail($id);
        $jenis_kelas->update($request->only('jeniskelas'));

        return redirect()->route('admin.jenis_kelas.index')
                         ->with('success', 'Jenis Kelas berhasil diperbarui.');
    }

    // Menghapus jenis kelas
    public function destroy($id)
    {
        $jenis_kelas = JenisKelas::findOrFail($id);
        $jenis_kelas->delete();

        return redirect()->route('admin.jenis_kelas.index')
                         ->with('success', 'Jenis Kelas berhasil dihapus.');
    }
}
