<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\PendaftaranGuides;
use App\Models\JadwalGuide2;
use App\Models\GuideHasilFile;

class PendaftaranGuideController extends Controller
{
    /**
     * Daftar semua pendaftar Guide.
     */
    public function index()
    {
        $pendaftarans = PendaftaranGuides::with([
            'pendaftaran.user',
            'jadwalKonfirmasi',
            'paketGuide',
            'hasilFiles', // cek ada file hasil / zoom
        ])->latest()->get();

        return view('admin.pendaftaran.guides.index', compact('pendaftarans'));
    }

    /**
     * Detail pendaftaran.
     */
    public function show($id)
    {
        $pendaftaran = PendaftaranGuides::with([
            'pendaftaran.user',
            'jadwalKonfirmasi',
            'paketGuide',
            'hasilFiles.uploader',
        ])->findOrFail($id);

        // Jadwal untuk konfirmasi (paket 2)
        $jadwalPilihanIds = $pendaftaran->jadwalguide2_pilihan ?? [];
        $jadwalTersedia = collect();
        if ((int) $pendaftaran->paket_guide === 2 && !empty($jadwalPilihanIds)) {
            $jadwalTersedia = JadwalGuide2::whereIn('id_jadwalguide2', $jadwalPilihanIds)->get();
        }

        return view('admin.pendaftaran.guides.show', compact('pendaftaran', 'jadwalTersedia'));
    }

    /**
     * Konfirmasi jadwal (paket 2).
     */
    public function konfirmasiJadwal(Request $request, $id)
    {
        $request->validate([
            'jadwalguide2_konfirmasi' => 'required|exists:jadwal_guide2,id_jadwalguide2',
        ]);

        $pendaftaran = PendaftaranGuides::findOrFail($id);
        if ((int) $pendaftaran->paket_guide !== 2) {
            return back()->with('error', 'Jadwal hanya dapat dikonfirmasi untuk Paket 2.');
        }

        $pendaftaran->update([
            'jadwalguide2_konfirmasi' => $request->jadwalguide2_konfirmasi,
        ]);

        return redirect()
            ->route('admin.pendaftaran.guides.show', $pendaftaran->id)
            ->with('success', 'Jadwal berhasil dikonfirmasi.');
    }

    /**
     * Upload file hasil (paket 1 & 3) — hanya setelah status = diterima.
     */
    public function uploadHasil(Request $request, $id)
    {
        $pendaftaran = PendaftaranGuides::with('pendaftaran')->findOrFail($id);

        if (!in_array((int) $pendaftaran->paket_guide, [1, 3])) {
            return back()->with('error', 'Upload file hasil hanya untuk Paket 1 & 3.');
        }

        if (($pendaftaran->pendaftaran->status ?? null) !== 'diterima') {
            return back()->with('error', 'Status belum diterima; tidak dapat upload file hasil.');
        }

        $request->validate([
            'file_hasil' => 'required|file|max:5120|mimes:pdf,doc,docx,ppt,pptx,zip,rar',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $path = $request->file('file_hasil')->store('guide/hasil', 'public');

        GuideHasilFile::create([
            'pendaftaran_guide_id' => $pendaftaran->id,
            'file_hasil'           => $path,
            'link_zoom'            => null,
            'uploaded_by'          => Auth::id(),
            'keterangan'           => $request->keterangan,
        ]);

        return back()->with('success', 'File hasil berhasil diunggah.');
    }

    /**
     * Simpan / update Link Zoom (paket 2) — hanya setelah status = diterima & jadwal terkonfirmasi.
     * Kita simpan sebagai baris di guide_hasil_files dengan kolom link_zoom.
     */
    public function simpanZoom(Request $request, $id)
    {
        $pendaftaran = PendaftaranGuides::with('pendaftaran')->findOrFail($id);

        if ((int) $pendaftaran->paket_guide !== 2) {
            return back()->with('error', 'Link Zoom hanya untuk Paket 2.');
        }

        if (!$pendaftaran->jadwalguide2_konfirmasi) {
            return back()->with('error', 'Konfirmasi jadwal dulu sebelum input Link Zoom.');
        }

        if (($pendaftaran->pendaftaran->status ?? null) !== 'diterima') {
            return back()->with('error', 'Status belum diterima; tidak dapat input Link Zoom.');
        }

        $request->validate([
            'link_zoom' => 'required|url|max:2048',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan baris baru; bisa juga updateOrCreate bila ingin 1 link saja.
        GuideHasilFile::create([
            'pendaftaran_guide_id' => $pendaftaran->id,
            'file_hasil'           => null,
            'link_zoom'            => $request->link_zoom,
            'uploaded_by'          => Auth::id(),
            'keterangan'           => $request->keterangan ?? 'Link Zoom pertemuan',
        ]);

        return back()->with('success', 'Link Zoom berhasil disimpan.');
    }

    /**
     * Hapus satu file hasil / link zoom.
     * Jika file_hasil ada, hapus file fisik; kalau hanya link, tidak ada file.
     */
    public function hapusHasil($fileId)
    {
        $file = GuideHasilFile::findOrFail($fileId);

        if ($file->file_hasil && Storage::disk('public')->exists($file->file_hasil)) {
            Storage::disk('public')->delete($file->file_hasil);
        }

        $file->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
