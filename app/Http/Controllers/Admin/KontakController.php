<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kontak;

use Illuminate\Http\Request;

class KontakController extends Controller
{
    // Menampilkan semua data kontak
    public function index()
    {
        $kontaks = Kontak::all();
        return view('admin.kontak.index', compact('kontaks'));
    }

    // Menampilkan form untuk menambah kontak
    public function create()
    {
        return view('admin.kontak.create');
    }

    // Menyimpan data kontak baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kontak' => 'required|max:255',
            'isi' => 'nullable|max:255',
            'link' => 'nullable|max:1000',
        ]);

        Kontak::create($request->all());

        return redirect()->route('admin.kontak.index')
                         ->with('success', 'Kontak berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit kontak
    public function edit($id)
    {
        $kontak = Kontak::findOrFail($id);
        return view('admin.kontak.edit', compact('kontak'));
    }

    // Memperbarui data kontak
    public function update(Request $request, $id)
    {
        $request->validate([
            'kontak' => 'required|max:255',
            'isi' => 'nullable|max:255',
            'link' => 'nullable|max:1000',
        ]);

        $kontak = Kontak::findOrFail($id);
        $kontak->update($request->only(['kontak', 'isi', 'link']));

        return redirect()->route('admin.kontak.index')
                         ->with('success', 'Kontak berhasil diperbarui.');
    }

    // Menghapus data kontak
    public function destroy($id)
    {
        $kontak = Kontak::findOrFail($id);
        $kontak->delete();

        return redirect()->route('admin.kontak.index')
                         ->with('success', 'Kontak berhasil dihapus.');
    }
}
