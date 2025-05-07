<?php

namespace App\Http\Controllers;
use App\Models\PendaftaranGuides;

use Illuminate\Http\Request;

class PendaftaranGuideController extends Controller
{
    public function create($pendaftaranId)
    {
        return view('siswa.pendaftaran.guide', compact('pendaftaranId'));
    }

    public function store(Request $request, $pendaftaranId)
    {
        $data = [
            'pendaftaran_id' => $pendaftaranId,
            'paketguides' => $request->paketguides
        ];

        if (in_array($request->paketguides, [1, 3])) {
            $request->validate(['file_upload' => 'required|file']);
            $data['file_upload'] = $request->file('file_upload')->store('guide_files');
        } elseif ($request->paketguides == 2) {
            $request->validate(['jadwalguide2_pilihan' => 'required|array|max:3']);
            $data['jadwalguide2_pilihan'] = json_encode($request->jadwalguide2_pilihan);
        }

        PendaftaranGuides::create($data);
        return redirect()->route('dashboard')->with('success', 'Pendaftaran berhasil. Menunggu konfirmasi admin.');
    }

    public function konfirmasiJadwal(Request $request, $id)
    {
        $request->validate(['jadwalguide2_konfirmasi' => 'required']);

        $guide = PendaftaranGuides::findOrFail($id);
        $guide->update(['jadwalguide2_konfirmasi' => $request->jadwalguide2_konfirmasi]);

        return back()->with('success', 'Jadwal berhasil dikonfirmasi. Silakan upload bukti pembayaran.');
    }
}
