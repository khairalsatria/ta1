<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\KategoriBlog;
use App\Models\User; // Tambahkan ini

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['kategoriBlog', 'penulisUser'])->get(); // agar bisa ambil relasi user
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        $kategoriBlogs = KategoriBlog::all();
        $users = User::whereIn('role', ['admin', 'mentor'])->get(); // ambil user dengan role admin & mentor
        return view('admin.blog.create', compact('kategoriBlogs', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'tanggal_posting' => 'required|date',
            'isi' => 'required',
            'penulis' => 'required|exists:users,id',
            'kategori' => 'required|exists:kategori_blogs,id_kategori_blog',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_blog', 'public');
        }

        Blog::create($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog berhasil ditambahkan');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        $kategoriBlogs = KategoriBlog::all();
        $users = User::whereIn('role', ['admin', 'mentor'])->get();
        return view('admin.blog.edit', compact('blog', 'kategoriBlogs', 'users'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'tanggal_posting' => 'required|date',
            'isi' => 'required',
            'penulis' => 'required|exists:users,id',
            'kategori' => 'required|exists:kategori_blogs,id_kategori_blog',
            'gambar' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('gambar_blog', 'public');
        }

        $blog->update($data);

        return redirect()->route('admin.blog.index')->with('success', 'Blog berhasil diupdate');
    }

    public function destroy($id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();

        return redirect()->route('admin.blog.index')->with('success', 'Blog berhasil dihapus');
    }
}
