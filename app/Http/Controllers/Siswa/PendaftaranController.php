<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{PendaftaranClass, JenisKelas, MataPelajaran, JadwalKelas, PromosiClass, JenjangPendidikan};

class PendaftaranController extends Controller
{
    public function create()
    {
        $jenisKelas = JenisKelas::all();
        $jadwalKelas = JadwalKelas::all();
        $hargaPromosi = PromosiClass::latest()->first()->harga ?? 0;

        $jenjangPendidikans = JenjangPendidikan::all(); // Gunakan plural sesuai yang dipanggil di view
return view('siswa.pendaftaran.form', compact('jenisKelas', 'jenjangPendidikans', 'jadwalKelas', 'hargaPromosi'));
    }
 public function store(Request $request)
{
    $request->validate([
        'jadwal_pilihan' => 'required|array|max:3',
        'nama' => 'required|string',
        'email' => 'required|email',
        'nohp' => 'required|string',
        'id_jeniskelas' => 'required|integer',
        'kelas' => 'required|string',
        'id_jenjang_pendidikan' => 'required|integer', // Perbarui sesuai kolom
        'id_mata_pelajaran' => 'required|integer', // Perbarui sesuai kolom
        'harga' => 'required|numeric',
    ]);

    $pendaftaran = PendaftaranClass::create([
        'nama' => $request->nama,
        'email' => $request->email,
        'nohp' => $request->nohp,
        'id_jeniskelas' => $request->id_jeniskelas,
        'kelas' => $request->kelas,
        'jenjang_pendidikan' => $request->id_jenjang_pendidikan, // Perbarui sesuai kolom
        'mata_pelajaran' => $request->id_mata_pelajaran, // Perbarui sesuai kolom
        'jadwal_pilihan' => json_encode($request->jadwal_pilihan),
        'harga' => $request->harga,
        'status_pembayaran' => 'menunggu_jadwal', // Status awal
    ]);

    return redirect()->route('siswa.pendaftaran.formEmail', $pendaftaran->id)->with('success', 'Pendaftaran berhasil! Silakan masukkan email untuk melihat detail pendaftaran.');
}

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }


    public function dashboard(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $pendaftaran = PendaftaranClass::findOrFail($id);

    if ($pendaftaran->email !== $request->email) {
        return back()->with('error', 'Email tidak cocok dengan data pendaftaran.');
    }

    // Ambil konfirmasi jadwal
    $jadwalKonfirmasiId = $pendaftaran->jadwal_konfirmasi; // Ambil ID jadwal konfirmasi
    $jadwalKonfirmasi = JadwalKelas::find($jadwalKonfirmasiId); // Ambil data jadwal berdasarkan ID

    return view('siswa.dashboard.index', [
        'pendaftaran' => $pendaftaran,
        'email' => $request->email,
        'jadwalKonfirmasi' => $jadwalKonfirmasi, // Kirim data konfirmasi jadwal ke view
    ]);
}

    public function uploadForm($id)
    {
        $pendaftaran = PendaftaranClass::findOrFail($id);
        return view('siswa.pendaftaran.upload-bukti', compact('pendaftaran'));
    }

    public function uploadBukti(Request $request, $id)
    {
        $pendaftaran = PendaftaranClass::findOrFail($id);

        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
            $pendaftaran->update(['bukti_pembayaran' => $path]);
        }

        return redirect()->route('siswa.pendaftaran.form')->with('success', 'Bukti pembayaran berhasil diupload');
    }

    public function mataPelajaranByJenjang($id)
    {
        return response()->json(MataPelajaran::where('jenjang_pendidikan', $id)->get());
    }
}
