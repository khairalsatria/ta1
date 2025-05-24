<?php

namespace App\Http\Controllers;


use Midtrans\Snap;
use Midtrans\Config;
use App\Models\{
    PendaftaranProgram,
    PendaftaranLearns,
    Program
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranLearnController extends Controller
{
    public function create($program_id)
    {
        $program = Program::findOrFail($program_id);
        $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();

        return view('landing.page.detail-program-learn', compact(
            'program', 'relatedPrograms'
        ));
    }

    public function store(Request $request)
{
    $request->validate([
        'asal_instansi' => 'required|string|max:255',
        'tipe_program' => 'required|exists:programs,id',
    ]);

    $program = Program::findOrFail($request->tipe_program);

    // Setup Midtrans
    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = config('midtrans.isSanitized');
    Config::$is3ds = config('midtrans.is3ds');

    // Buat entry pendaftaran program tanpa token dulu
    $pendaftaranProgram = PendaftaranProgram::create([
        'user_id' => Auth::id(),
        'tipe_program' => $program->id,
        'harga' => $program->harga,
        'status' => 'menunggu',
    ]);

    // Buat entry detail Learn
    PendaftaranLearns::create([
        'pendaftaran_id' => $pendaftaranProgram->id,
        'asal_instansi' => $request->asal_instansi,
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
    ]);

    // Simpan token sebagai link pembayaran
    $pendaftaranProgram->update([
        'link_pembayaran' => $snapToken,
    ]);

    return redirect()->route('siswa.pendaftaran.status', $pendaftaranProgram->id)
        ->with('success', 'Pendaftaran berhasil. Silakan lanjut ke pembayaran.');
}



    public function uploadSertifikat(Request $request, $id)
    {
        $request->validate([
            'sertifikat' => 'required|file|mimes:pdf',
        ]);

        $filePath = $request->file('sertifikat')->store('sertifikat', 'public');

        $learn = PendaftaranLearns::findOrFail($id);
        $learn->update(['sertifikat' => $filePath]);

        return back()->with('success', 'Sertifikat berhasil diunggah.');
    }

    public function formEmail($id)
    {
        return view('siswa.pendaftaran.form-email', ['pendaftaran_id' => $id]);
    }
}
