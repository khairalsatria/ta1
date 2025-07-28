<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;

use App\Models\{
    PendaftaranProgram,
    PendaftaranClasses,
    JenisKelas,
    JenjangPendidikan,
    MataPelajaran,
    JadwalKelas,
    Program,
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PendaftaranClassController extends Controller
{
    public function create($program_id)
    {
        $jenisKelas = JenisKelas::all();
        $jenjangPendidikans = JenjangPendidikan::all();
        $jadwalKelas = JadwalKelas::all();
        $program = Program::findOrFail($program_id);
        $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();

        return view('landing.page.detail-program', compact(
            'jenisKelas',
            'jenjangPendidikans',
            'jadwalKelas',
            'program',
            'relatedPrograms'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pilihan' => 'required|array|min:3',
            'id_jeniskelas' => 'required|integer',
            'kelas' => 'required|string|max:10',
            'id_jenjang_pendidikan' => 'required|integer',
            'id_mata_pelajaran' => 'required|integer',
        ]);

        // Ambil data program
        $program = Program::findOrFail($request->tipe_program);

        // Setup Midtrans
        Config::$serverKey = config('midtrans.serverKey');
        Config::$isProduction = config('midtrans.isProduction');
        Config::$isSanitized = config('midtrans.isSanitized');
        Config::$is3ds = config('midtrans.is3ds');

        // Buat entry utama pendaftaran program
        $pendaftaranProgram = PendaftaranProgram::create([
            'user_id' => Auth::id(),
            'tipe_program' => $program->id,
            'harga' => $program->harga,
            'status' => 'menunggu',
        ]);

        // Buat entry detail untuk GenZE Class
        PendaftaranClasses::create([
            'pendaftaran_id' => $pendaftaranProgram->id,
            'jeniskelas' => $request->id_jeniskelas,
            'kelas' => $request->kelas,
            'jenjang_pendidikan' => $request->id_jenjang_pendidikan,
            'mata_pelajaran' => $request->id_mata_pelajaran,
            'jadwalkelas_pilihan' => $request->jadwal_pilihan,
        ]);

        // Generate Snap Token Midtrans
        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => 'ORDER-' . $pendaftaranProgram->id,
                'gross_amount' => (int) $program->harga,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],

            'callbacks' => [
        'finish' => route('siswa.pendaftaran.status', $pendaftaranProgram->id)
    ]
        ]);


        // Simpan Snap Token sebagai link pembayaran
        $pendaftaranProgram->update([
            'link_pembayaran' => $snapToken,
        ]);

        return redirect()->route('siswa.pendaftaran.status', $pendaftaranProgram->id)
            ->with('success', 'Pendaftaran berhasil! Silakan lanjut ke pembayaran.');
    }

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }

    public function mataPelajaranByJenjang($id)
    {
        return response()->json(
            MataPelajaran::where('jenjang_pendidikan', $id)->get()
        );
    }

    public function responAlternatif(Request $request, $id)
{
    $pendaftaran = PendaftaranClasses::with('pendaftaran')->findOrFail($id);

    if ($request->respon == 'terima') {
        $pendaftaran->status_alternatif = 'diterima';
        $pendaftaran->jadwalkelas_konfirmasi = $pendaftaran->jadwalkelas_alternatif;
        $pendaftaran->save();

        return redirect()->route('siswa.pendaftaran.status', $pendaftaran->pendaftaran_id)
            ->with('success', 'Anda telah menyetujui jadwal alternatif. Silakan lanjut ke pembayaran.');
    } else {
        $pendaftaran->status_alternatif = 'ditolak';
        $pendaftaran->save();

        return redirect()->route('siswa.pendaftaran.status', $pendaftaran->pendaftaran_id)
            ->with('error', 'Anda menolak jadwal alternatif. Pendaftaran dihentikan.');
    }
}

    
}
