<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PendaftaranProgramController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input, pastikan tipe_program valid
        $request->validate([
            'tipe_program' => 'required|exists:programs,id',  // Pastikan tipe_program ada di tabel programs
        ]);

        // Ambil program berdasarkan tipe_program yang diterima
        $program = Program::findOrFail($request->tipe_program);

        // // Simpan data pendaftaran program
        // $pendaftaran = PendaftaranProgram::create([
        //     'user_id' => Auth::id(), // ID user yang sedang login
        //     'tipe_program' => $program->id, // Menyimpan ID tipe_program dari tabel programs
        //     'harga' => $program->harga, // Menyimpan harga dari tabel programs
        // ]);

        // Arahkan ke form sesuai tipe program
        if ($program->tipe_program === 'GenZE Class') {
            return redirect()->route('siswa.pendaftaran.genze-class.form');

        } elseif ($program->tipe_program === 'GenZE Guide') {
            return redirect()->route('siswa.pendaftaran.genze-guide-form');
        } elseif ($program->tipe_program === 'GenZE Learn') {
            return redirect()->route('pendaftaran.learn.create');
        }

        return back()->with('error', 'Tipe program tidak valid.');
    }

    // Fungsi upload bukti pembayaran
    public function uploadBukti(Request $request, $id)
    {
        // Validasi file yang diupload
        $request->validate([
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ]);

        // Temukan pendaftaran berdasarkan ID
        $pendaftaran = PendaftaranProgram::findOrFail($id);

        // Simpan bukti pembayaran yang diupload ke storage
        $filePath = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');

        // Update data pendaftaran dengan path bukti pembayaran
        $pendaftaran->update(['bukti_pembayaran' => $filePath]);

        return back()->with('success', 'Bukti pembayaran berhasil diupload.');
    }

    // Fungsi untuk memverifikasi status pendaftaran
    public function verifikasi($id, $status)
    {
        // Temukan pendaftaran berdasarkan ID
        $pendaftaran = PendaftaranProgram::findOrFail($id);

        // Update status pendaftaran
        $pendaftaran->update(['status' => $status]);

        return back()->with('success', 'Status berhasil diperbarui.');
    }
}
