<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\KategoriBlog;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class KategoriBlogController extends Controller
{
    // Menampilkan semua kategori_blog
    public function index()
    {
        $kategori_blog = KategoriBlog::all();
        return view('admin.kategori_blog.index', compact('kategori_blog'));
    }

    // Menampilkan form untuk menambah kategori_blog
    public function create()
    {
        return view('admin.kategori_blog.create');
    }

    // Menyimpan kategori_blog baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'kategori_blog' => 'required|max:50',
        ]);

        // Menyimpan data kategori_blog
        KategoriBlog::create($request->all());

        return redirect()->route('admin.kategori_blog.index')
                         ->with('success', 'Kategori Blog berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit kategori_blog
    public function edit($id)
    {
        $kategori_blog = KategoriBlog::findOrFail($id);
        return view('admin.kategori_blog.edit', compact('kategori_blog'));
    }

    // Memperbarui data kategori_blog yang ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_blog' => 'required|max:50',
        ]);

        $kategori_blog = KategoriBlog::findOrFail($id);
        $kategori_blog->update($request->only('kategori_blog'));

        return redirect()->route('admin.kategori_blog.index')
                         ->with('success', 'Kategori Blog berhasil diperbarui.');
    }

    // Menghapus kategori_blog
    public function destroy($id)
    {
        $kategori_blog = KategoriBlog::findOrFail($id);
        $kategori_blog->delete();

        return redirect()->route('admin.kategori_blog.index')
                         ->with('success', 'Kategori Blog berhasil dihapus.');
    }
}
