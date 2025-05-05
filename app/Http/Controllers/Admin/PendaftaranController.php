<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranClass;
use App\Models\JadwalKelas;

class PendaftaranController extends Controller
{
    // Tampilkan semua data pendaftar
    public function index()
    {
        // >>> Tambahkan eager loading relasi jenjangPendidikan dan mataPelajaran
        $pendaftaranList = PendaftaranClass::with(['jenjangPendidikan', 'mataPelajaran'])->get();

        // Set status default jika kosong
        foreach ($pendaftaranList as $item) {
            if (!$item->status_pembayaran) {
                $item->status_pembayaran = 'menunggu_jadwal';
            }
        }

        return view('admin.pendaftaran.index', compact('pendaftaranList'));
    }

    // Tampilkan detail dari satu pendaftaran
    public function show($id)
    {
        // >>> Tambahkan eager loading relasi juga di sini
        $pendaftaran = PendaftaranClass::with(['jenjangPendidikan', 'mataPelajaran'])->findOrFail($id);

        // Decode jadwal_pilihan jika dalam format JSON string
        if (is_string($pendaftaran->jadwal_pilihan)) {
            $pendaftaran->jadwal_pilihan = json_decode($pendaftaran->jadwal_pilihan);
        }

        if (!is_array($pendaftaran->jadwal_pilihan) && !is_object($pendaftaran->jadwal_pilihan)) {
            $pendaftaran->jadwal_pilihan = [];
        }

        $jadwalKelas = JadwalKelas::whereIn('id_jadwalkelas', (array) $pendaftaran->jadwal_pilihan)->get();

        return view('admin.pendaftaran.show', compact('pendaftaran', 'jadwalKelas'));
    }

    // Konfirmasi Jadwal oleh admin
    public function konfirmasiJadwal(Request $request, $id)
    {
        $request->validate([
            'jadwal_konfirmasi' => 'required|exists:jadwal_kelas,id_jadwalkelas',
        ]);

        $pendaftaran = PendaftaranClass::findOrFail($id);

        // Update jadwal konfirmasi dan ubah status menjadi menunggu pembayaran
        $pendaftaran->update([
            'jadwal_konfirmasi' => $request->jadwal_konfirmasi,
            'status_pembayaran' => 'menunggu_pembayaran',
        ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Jadwal berhasil dikonfirmasi. Silakan tunggu bukti pembayaran.');
    }

    // Tampilkan form verifikasi pembayaran
    public function showVerifikasiPembayaranForm($id)
    {
        // >>> Tambahkan eager loading relasi supaya tampil lengkap kalau butuh nama jenjang/mapel
        $pendaftaran = PendaftaranClass::with(['jenjangPendidikan', 'mataPelajaran'])->findOrFail($id);

        return view('admin.pendaftaran.verifikasi_pembayaran', compact('pendaftaran'));
    }

    // Proses verifikasi pembayaran
    public function verifikasiPembayaran(Request $request, $id)
    {
        $request->validate([
            'status_pembayaran' => 'required|in:diterima,ditolak',
        ]);

        $pendaftaran = PendaftaranClass::findOrFail($id);

        $status = $request->status_pembayaran === 'diterima' ? 'pembayaran_berhasil' : 'pembayaran_ditolak';

        $pendaftaran->update([
            'status_pembayaran' => $status,
        ]);

        return redirect()->route('admin.pendaftaran.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}
