<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\JenjangPendidikan;
use Illuminate\Http\Request;

class JenjangPendidikanController extends Controller
{
     // Menampilkan semua jenjang_pendidikan
     public function index()
     {
         $jenjang_pendidikan = JenjangPendidikan::all();
         return view('admin.jenjang_pendidikan.index', compact('jenjang_pendidikan'));
     }

     // Menampilkan form untuk menambah jenjang_pendidikan
     public function create()
     {
         return view('admin.jenjang_pendidikan.create');
     }

     // Menyimpan jenjang_pendidikan baru ke database
     public function store(Request $request)
     {
         $request->validate([
             'jenjang_pendidikan' => 'required|max:50',
         ]);

         // Menyimpan data jenjang_pendidikan
         JenjangPendidikan::create($request->all());

         return redirect()->route('admin.jenjang_pendidikan.index')
                          ->with('success', 'Jenjang Pendidikan berhasil ditambahkan.');
     }

     // Menampilkan form untuk mengedit jenjang_pendidikan
     public function edit($id)
     {
         $jenjang_pendidikan = JenjangPendidikan::findOrFail($id);
         return view('admin.jenjang_pendidikan.edit', compact('jenjang_pendidikan'));
     }

     // Memperbarui data jenjang_pendidikan yang ada
     public function update(Request $request, $id)
     {
         $request->validate([
             'jenjang_pendidikan' => 'required|max:50',
         ]);

         $jenjang_pendidikan = JenjangPendidikan::findOrFail($id);
         $jenjang_pendidikan->update($request->only('jenjang_pendidikan'));

         return redirect()->route('admin.jenjang_pendidikan.index')
                          ->with('success', 'Jenjang Pendidikan berhasil diperbarui.');
     }

     // Menghapus jenjang_pendidikan
     public function destroy($id)
     {
         $jenjang_pendidikan = JenjangPendidikan::findOrFail($id);
         $jenjang_pendidikan->delete();

         return redirect()->route('admin.jenjang_pendidikan.index')
                          ->with('success', 'Jenjang Pendidikan berhasil dihapus.');
     }
}
