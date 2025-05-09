<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Program;

class ProgramController extends Controller
{
    // Tampilkan semua program
    public function index()
{
    $programs = Program::all(); // Menambahkan pagination 6 item per halaman
    return view('admin.program.index', compact('programs'));
}


    // Tampilkan form untuk membuat program baru
    public function create()
    {
        $tipe_programs = ['GenZE Class', 'GenZE Guide', 'GenZE Learn'];
        return view('admin.program.create', compact('tipe_programs'));
    }

    // Simpan program baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_program' => 'required|string|max:255',
            'tipe_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:10',
            'instruktur' => 'required|string|max:255',
            'durasi' => 'required|string|max:50',
            'level' => 'required|string|max:50',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('program_thumbnails', 'public');
        }

        Program::create([
            'nama_program' => $request->nama_program,
            'tipe_program' => $request->tipe_program,
            'deskripsi' => $request->deskripsi,
            'fitur' => $request->fitur,
            'rating' => $request->rating,
            'instruktur' => $request->instruktur,
            'durasi' => $request->durasi,
            'level' => $request->level,
            'harga' => $request->harga,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('admin.program.index')->with('success', 'Program berhasil ditambahkan.');
    }

    // Tampilkan form edit program
    public function edit($id)
    {
        $program = Program::findOrFail($id);
        $tipe_programs = ['GenZE Class', 'GenZE Guide', 'GenZE Learn'];
        return view('admin.program.edit', compact('program', 'tipe_programs'));
    }

    // Update program
    public function update(Request $request, $id)
    {
        $program = Program::findOrFail($id);

        $request->validate([
            'nama_program' => 'required|string|max:255',
            'tipe_program' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'fitur' => 'nullable|string',
            'rating' => 'required|numeric|min:0|max:10',
            'instruktur' => 'required|string|max:255',
            'durasi' => 'required|string|max:50',
            'level' => 'required|string|max:50',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('program_thumbnails', 'public');
            $program->gambar = $gambarPath;
        }

        $program->update([
            'nama_program' => $request->nama_program,
            'tipe_program' => $request->tipe_program,
            'deskripsi' => $request->deskripsi,
            'fitur' => $request->fitur,
            'rating' => $request->rating,
            'instruktur' => $request->instruktur,
            'durasi' => $request->durasi,
            'level' => $request->level,
            'harga' => $request->harga,
            'gambar' => $program->gambar,
        ]);

        return redirect()->route('admin.program.index')->with('success', 'Program berhasil diperbarui.');
    }
}
