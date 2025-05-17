<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranLearns;
use App\Models\PendaftaranProgram;

class PendaftaranLearnController extends Controller
{
    public function index()
    {
        $pendaftarans = PendaftaranLearns::with('pendaftaran.user')->latest()->get();
        return view('admin.pendaftaran.learns.index', compact('pendaftarans'));
    }

    public function show($id)
    {
        $pendaftaran = PendaftaranLearns::with('pendaftaran.user')->findOrFail($id);
        return view('admin.pendaftaran.learns.show', compact('pendaftaran'));
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranLearns::findOrFail($id);
        $program = PendaftaranProgram::findOrFail($pendaftaran->pendaftaran_id);

        $program->status = $request->status;
        $program->save();

        return redirect()->route('admin.pendaftaran.learns.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function uploadSertifikat(Request $request, $id)
    {
        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf',
        ]);

        $filePath = $request->file('sertifikat')->store('sertifikat', 'public');

        $pendaftaran = PendaftaranLearns::findOrFail($id);
        $pendaftaran->update(['sertifikat' => $filePath]);

        return back()->with('success', 'Sertifikat berhasil diunggah.');
    }
}
