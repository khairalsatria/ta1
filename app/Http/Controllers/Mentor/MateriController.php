<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\MateriPertemuan;
use App\Models\KelasGenze;
use Illuminate\Support\Facades\Auth;

class MateriController extends Controller
{
    public function create($kelas_id)
    {
        $kelas = KelasGenze::findOrFail($kelas_id);
        return view('mentor.materi.create', compact('kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas_genze,id',
            'tanggal_pertemuan' => 'required|date',
            'pertemuan_ke' => 'required|integer|min:1|max:8',
            'judul' => 'required|string|max:255',
            'file_pdf' => 'nullable|file|mimes:pdf|max:2048',
            'link_zoom' => 'nullable|url',
            'link_rekaman' => 'nullable|url'
        ]);

        $path = null;
        if ($request->hasFile('file_pdf')) {
            $path = $request->file('file_pdf')->store('materi', 'public');
        }

        MateriPertemuan::create([
            'kelas_id' => $request->kelas_id,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'pertemuan_ke' => $request->pertemuan_ke,
            'judul' => $request->judul,
            'file_pdf' => $path,
            'link_zoom' => $request->link_zoom,
            'link_rekaman' => $request->link_rekaman,
        ]);

        return redirect()->route('mentor.dashboard')->with('success', 'Materi berhasil ditambahkan.');
    }
}
