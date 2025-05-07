<?php

namespace App\Http\Controllers;
use App\Models\PendaftaranLearns;


use Illuminate\Http\Request;

class PendaftaranLearnController extends Controller
{
    public function create($pendaftaranId)
    {
        return view('siswa.pendaftaran.learn', compact('pendaftaranId'));
    }

    public function store(Request $request, $pendaftaranId)
    {
        $request->validate(['asal_instansi' => 'required']);

        PendaftaranLearns::create([
            'pendaftaran_id' => $pendaftaranId,
            'asal_instansi' => $request->asal_instansi
        ]);

        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil. Silakan upload bukti pembayaran.');
    }

    public function uploadSertifikat(Request $request, $id)
    {
        $request->validate(['sertifikat' => 'required|file|mimes:pdf']);
        $filePath = $request->file('sertifikat')->store('sertifikat');

        $learn = PendaftaranLearns::findOrFail($id);
        $learn->update(['sertifikat' => $filePath]);

        return back()->with('success', 'Sertifikat berhasil diunggah.');
    }

}
