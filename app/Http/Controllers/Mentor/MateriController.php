<?php

namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MateriPertemuan;
use App\Models\KelasGenze;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    // ✅ List materi hanya milik mentor login
    public function index()
    {
        $materi = MateriPertemuan::whereHas('kelas', function ($query) {
            $query->where('mentor_id', Auth::id());
        })->with('kelas')->get();

        return view('mentor.materi.index', compact('materi'));
    }

    // ✅ Tampilkan form tambah materi
    public function create(Request $request)
    {
        $kelas_id = $request->query('kelas_id');
        $kelas = KelasGenze::where('mentor_id', Auth::id())->find($kelas_id);
        $semua_kelas = KelasGenze::where('mentor_id', Auth::id())->get();

        return view('mentor.materi.create', compact('semua_kelas', 'kelas_id', 'kelas'));
    }

    // ✅ Simpan materi baru
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

        // Validasi kelas milik mentor
        $kelas = KelasGenze::where('mentor_id', Auth::id())->findOrFail($request->kelas_id);

        $path = null;
        if ($request->hasFile('file_pdf')) {
            $path = $request->file('file_pdf')->store('materi', 'public');
        }

        MateriPertemuan::create([
            'kelas_id' => $kelas->id,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'pertemuan_ke' => $request->pertemuan_ke,
            'judul' => $request->judul,
            'file_pdf' => $path,
            'link_zoom' => $request->link_zoom,
            'link_rekaman' => $request->link_rekaman,
        ]);

        return redirect()->route('mentor.materi.index')->with('success', 'Materi berhasil ditambahkan.');
    }

    // ✅ Edit materi
    public function edit($id)
    {
        $materi = MateriPertemuan::whereHas('kelas', function ($query) {
            $query->where('mentor_id', Auth::id());
        })->findOrFail($id);

        $semua_kelas = KelasGenze::where('mentor_id', Auth::id())->get();
        return view('mentor.materi.edit', compact('materi', 'semua_kelas'));
    }

    // ✅ Update materi
    public function update(Request $request, $id)
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

        $materi = MateriPertemuan::whereHas('kelas', function ($query) {
            $query->where('mentor_id', Auth::id());
        })->findOrFail($id);

        if ($request->hasFile('file_pdf')) {
            if ($materi->file_pdf && Storage::disk('public')->exists($materi->file_pdf)) {
                Storage::disk('public')->delete($materi->file_pdf);
            }

            $materi->file_pdf = $request->file('file_pdf')->store('materi', 'public');
        }

        $materi->update([
            'kelas_id' => $request->kelas_id,
            'tanggal_pertemuan' => $request->tanggal_pertemuan,
            'pertemuan_ke' => $request->pertemuan_ke,
            'judul' => $request->judul,
            'link_zoom' => $request->link_zoom,
            'link_rekaman' => $request->link_rekaman,
            'file_pdf' => $materi->file_pdf,
        ]);

        return redirect()->route('mentor.kelas.show', $materi->kelas_id)->with('success', 'Materi berhasil diperbarui.');
    }

    // ✅ Hapus materi
    public function destroy($id)
    {
        $materi = MateriPertemuan::whereHas('kelas', function ($query) {
            $query->where('mentor_id', Auth::id());
        })->findOrFail($id);

        if ($materi->file_pdf && Storage::disk('public')->exists($materi->file_pdf)) {
            Storage::disk('public')->delete($materi->file_pdf);
        }

        $materi->delete();

        return redirect()->route('mentor.materi.index')->with('success', 'Materi berhasil dihapus.');
    }
}
