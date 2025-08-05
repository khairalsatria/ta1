<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Keuangan;
use App\Models\PendaftaranProgram;
    use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class KeuanganController extends Controller
{

public function index()
{
    // Ambil data manual dari tabel keuangans
    $manualKeuangans = Keuangan::select(
        'id',
        'tanggal',
        'jenis_transaksi',
        'keterangan',
        'jumlah',
        DB::raw("'manual' as sumber")
    );

    // Ambil data pemasukan dari pendaftaran program (status diterima)

  $pendaftaranKeuangans = DB::table('pendaftaran_programs')
    ->join('programs', 'pendaftaran_programs.tipe_program', '=', 'programs.id')
    ->where('pendaftaran_programs.status', 'diterima')
    ->select(
        DB::raw("NULL as id"),
        'pendaftaran_programs.created_at as tanggal',
        DB::raw("'pemasukan' as jenis_transaksi"),
            DB::raw("CONCAT('Pendaftaran Program ', programs.tipe_program) as keterangan"), // ambil nama program dari tabel relasi
        'pendaftaran_programs.harga as jumlah',
        DB::raw("'pendaftaran' as sumber")
    );

    // Gabungkan semuanya
    $keuangans = $manualKeuangans
        ->unionAll($pendaftaranKeuangans)
        ->orderBy('tanggal', 'desc')
        ->get();

    // Hitung total
    $totalPemasukanManual = Keuangan::where('jenis_transaksi', 'pemasukan')->sum('jumlah');
    $totalPemasukanPendaftaran = PendaftaranProgram::where('status', 'diterima')->sum('harga');
    $totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')->sum('jumlah');

    $totalSaldo = $totalPemasukanManual + $totalPemasukanPendaftaran - $totalPengeluaran;

    return view('admin.keuangan.index', compact(
        'keuangans',
        'totalPemasukanManual',
        'totalPemasukanPendaftaran',
        'totalPengeluaran',
        'totalSaldo'
    ));
}


    public function create()
    {
        return view('admin.keuangan.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'tanggal' => 'required|date',
        'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
        'keterangan' => 'nullable|string',
        'jumlah' => 'required|numeric|min:0',
    ]);

    Keuangan::create($request->all());

    return redirect()->route('admin.keuangan.index')
                     ->with('success', 'Transaksi berhasil ditambahkan.');
}


    public function edit($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        return view('admin.keuangan.edit', compact('keuangan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenis_transaksi' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'nullable|string',
            'jumlah' => 'required|numeric|min:0',
        ]);

        $keuangan = Keuangan::findOrFail($id);
        $keuangan->update($request->all());

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $keuangan = Keuangan::findOrFail($id);
        $keuangan->delete();

        return redirect()->route('admin.keuangan.index')->with('success', 'Transaksi berhasil dihapus.');
    }



public function cetak(Request $request)
{
    $bulan = $request->input('bulan'); // format: 01, 02, ..., 12
    $tahun = $request->input('tahun'); // format: 2025, 2024, etc.

    // Validasi sederhana
    if (!$bulan || !$tahun) {
        return redirect()->back()->with('error', 'Bulan dan tahun harus dipilih untuk mencetak laporan.');
    }

    // Ambil data manual dari keuangan
    $manualKeuangans = Keuangan::whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->select(
            'id',
            'tanggal',
            'jenis_transaksi',
            'keterangan',
            'jumlah',
            DB::raw("'manual' as sumber")
        );

    // Ambil data dari pendaftaran program
    $pendaftaranKeuangans = DB::table('pendaftaran_programs')
        ->join('programs', 'pendaftaran_programs.tipe_program', '=', 'programs.id')
        ->where('pendaftaran_programs.status', 'diterima')
        ->whereMonth('pendaftaran_programs.created_at', $bulan)
        ->whereYear('pendaftaran_programs.created_at', $tahun)
        ->select(
            DB::raw("NULL as id"),
            'pendaftaran_programs.created_at as tanggal',
            DB::raw("'pemasukan' as jenis_transaksi"),
            DB::raw("CONCAT('Pendaftaran Program ', programs.tipe_program) as keterangan"),
            'pendaftaran_programs.harga as jumlah',
            DB::raw("'pendaftaran' as sumber")
        );

    $keuangans = $manualKeuangans
        ->unionAll($pendaftaranKeuangans)
        ->orderBy('tanggal', 'desc')
        ->get();

    $totalPemasukanManual = Keuangan::where('jenis_transaksi', 'pemasukan')
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->sum('jumlah');

    $totalPemasukanPendaftaran = PendaftaranProgram::where('status', 'diterima')
        ->whereMonth('created_at', $bulan)
        ->whereYear('created_at', $tahun)
        ->sum('harga');

    $totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', $tahun)
        ->sum('jumlah');

    $totalSaldo = $totalPemasukanManual + $totalPemasukanPendaftaran - $totalPengeluaran;

    $pdf = Pdf::loadView('admin.keuangan.cetak', compact(
        'keuangans',
        'totalPemasukanManual',
        'totalPemasukanPendaftaran',
        'totalPengeluaran',
        'totalSaldo',
        'bulan',
        'tahun'
    ));

    return $pdf->download("laporan-keuangan-{$bulan}-{$tahun}.pdf");
}


}
