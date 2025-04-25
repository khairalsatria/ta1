<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GenzeLearn;
use Illuminate\Http\Request;

class GenzeLearnController extends Controller
{
    // Menampilkan semua data Genze Learn
    public function index()
    {
        $genzeLearns = GenzeLearn::all();
        return view('admin.genze_learn.index', compact('genzeLearns'));
    }

    // Menampilkan form untuk menambah data Genze Learn
    public function create()
    {
        return view('admin.genze_learn.create');
    }

    // Menyimpan data baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_learn' => 'required|max:255',
            'pembicara' => 'required|max:255',
            'jadwal' => 'required|date',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'link_zoom' => 'nullable|max:255',
            'sertifikat' => 'nullable|max:255',
        ]);

        GenzeLearn::create($request->all());

        return redirect()->route('admin.genze_learn.index')
                         ->with('success', 'Data Genze Learn berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit data
    public function edit($id)
    {
        $genzeLearn = GenzeLearn::findOrFail($id);
        return view('admin.genze_learn.edit', compact('genzeLearn'));
    }

    // Memperbarui data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_learn' => 'required|max:255',
            'pembicara' => 'required|max:255',
            'jadwal' => 'required|date',
            'harga' => 'required|numeric',
            'keterangan' => 'nullable|string',
            'link_zoom' => 'nullable|max:255',
            'sertifikat' => 'nullable|max:255',
        ]);

        $genzeLearn = GenzeLearn::findOrFail($id);
        $genzeLearn->update($request->all());

        return redirect()->route('admin.genze_learn.index')
                         ->with('success', 'Data Genze Learn berhasil diperbarui.');
    }

    // Menghapus data
    public function destroy($id)
    {
        $genzeLearn = GenzeLearn::findOrFail($id);
        $genzeLearn->delete();

        return redirect()->route('admin.genze_learn.index')
                         ->with('success', 'Data Genze Learn berhasil dihapus.');
    }
}
