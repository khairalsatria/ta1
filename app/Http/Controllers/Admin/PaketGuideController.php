<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PaketGuide;

use Illuminate\Http\Request;

class PaketGuideController extends Controller
{
    public function index()
    {
        $paket_guide = PaketGuide::all();
        return view('admin.paket_guide.index', compact('paket_guide'));
    }

    // Menampilkan form untuk menambah paket_guide
    public function create()
    {
        return view('admin.paket_guide.create');
    }

    // Menyimpan paket_guide baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'paket_guide' => 'required|max:50',
        ]);

        // Menyimpan data paket_guide
        PaketGuide::create($request->all());

        return redirect()->route('admin.paket_guide.index')
                         ->with('success', 'Paket Guide berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit paket_guide
    public function edit($id)
    {
        $paket_guide = PaketGuide::findOrFail($id);
        return view('admin.paket_guide.edit', compact('paket_guide'));
    }

    // Memperbarui data paket_guide yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'paket_guide' => 'required|max:50',
        ]);

        $paket_guide = PaketGuide::findOrFail($id);
        $paket_guide->update($request->only('paket_guide'));

        return redirect()->route('admin.paket_guide.index')
                         ->with('success', 'Paket Guide berhasil diperbarui.');
    }

    // Menghapus paket_guide
    public function destroy($id)
    {
        $paket_guide = PaketGuide::findOrFail($id);
        $paket_guide->delete();

        return redirect()->route('admin.paket_guide.index')
                         ->with('success', 'Paket Guide berhasil dihapus.');
    }
}
