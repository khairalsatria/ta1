<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use Midtrans\Config;

use App\Models\{
    PendaftaranProgram,
    PendaftaranGuides,
    Program,
    PaketGuide,
    JadwalGuide2
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PendaftaranGuideController extends Controller
{
    public function create($program_id)
{
    $paketGuides = PaketGuide::all();
    $jadwalGuide2 = JadwalGuide2::all();
    $program = Program::findOrFail($program_id);
    $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();

    return view('landing.page.detail-program', compact(
    'paketGuides', 'jadwalGuide2', 'program', 'relatedPrograms'
));

}



   public function store(Request $request)
{
    $request->validate([
        'paket_guide' => 'required|integer|in:1,2,3',
        'file_upload' => 'nullable|file|mimes:pdf,doc,docx,jpg,png,jpeg',
        'jadwalguide2_pilihan' => 'nullable|array|max:3',
    ]);

    $program = Program::findOrFail($request->tipe_program);

    // Setup Midtrans
    Config::$serverKey = config('midtrans.serverKey');
    Config::$isProduction = config('midtrans.isProduction');
    Config::$isSanitized = config('midtrans.isSanitized');
    Config::$is3ds = config('midtrans.is3ds');

    // Buat data utama pendaftaran
    $pendaftaranProgram = PendaftaranProgram::create([
        'user_id' => Auth::id(),
        'tipe_program' => $program->id,
        'harga' => $program->harga,
        'status' => 'menunggu',
    ]);

    // Simpan file jika ada
    $filePath = null;
    if ($request->hasFile('file_upload')) {
        $filePath = $request->file('file_upload')->store('guide_files', 'public');
    }

    // Simpan data ke tabel pendaftaran_guides
    PendaftaranGuides::create([
        'pendaftaran_id' => $pendaftaranProgram->id,
        'paket_guide' => $request->paket_guide,
        'file_upload' => $filePath,
        'jadwalguide2_pilihan' => $request->jadwalguide2_pilihan,
    ]);

    // Generate Midtrans Snap Token
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

    // Simpan link pembayaran
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

    public function jadwalGuide2ByPaket($id)
    {
        // Mengambil jadwal guide berdasarkan paket yang dipilih
        return response()->json(JadwalGuide2::where('paket_guide_id', $id)->get());
    }
}
