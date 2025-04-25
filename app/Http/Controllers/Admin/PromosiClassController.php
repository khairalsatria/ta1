<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PromosiClass;
use Illuminate\Http\Request;

class PromosiClassController extends Controller
{
    // Menampilkan semua promosi_class
    public function index()
    {
        $promosi_classes = PromosiClass::all();
        return view('admin.promosi_class.index', compact('promosi_classes'));
    }

    // Menampilkan form untuk menambah promosi_class
    public function create()
    {
        return view('admin.promosi_class.create');
    }

    // Menyimpan promosi_class baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'benefit' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        // Menyimpan data promosi_class
        $promosi_class = new PromosiClass($request->all());

        // Jika ada gambar, simpan gambar
        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/promosi'), $filename);
            $promosi_class->gambar = $filename;
        }

        $promosi_class->save();

        return redirect()->route('admin.promosi_class.index')
                         ->with('success', 'Promosi Class berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit promosi_class
    public function edit($id)
    {
        $promosi_class = PromosiClass::findOrFail($id);
        return view('admin.promosi_class.edit', compact('promosi_class'));
    }

    // Memperbarui data promosi_class yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'benefit' => 'required|string',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi untuk gambar
        ]);

        $promosi_class = PromosiClass::findOrFail($id);
        $promosi_class->update($request->except('gambar')); // Update tanpa gambar

        // Jika ada gambar baru, simpan gambar
        if ($request->hasFile('gambar')) {
            $filename = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/promosi'), $filename);
            $promosi_class->gambar = $filename;
        }

        $promosi_class->save();

        return redirect()->route('admin.promosi_class.index')
                         ->with('success', 'Promosi Class berhasil diperbarui.');
    }

    // Menghapus promosi_class
    public function destroy($id)
    {
        $promosi_class = PromosiClass::findOrFail($id);
        if ($promosi_class->gambar) {
            // Hapus gambar dari server jika ada
            unlink(public_path('images/promosi/' . $promosi_class->gambar));
        }
        $promosi_class->delete();

        return redirect()->route('admin.promosi_class.index')
                         ->with('success', 'Promosi Class berhasil dihapus.');
    }
}
