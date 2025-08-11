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
    $tanggalAwal = $request->input('tanggal_awal');
    $tanggalAkhir = $request->input('tanggal_akhir');

    if (!$tanggalAwal || !$tanggalAkhir) {
        return redirect()->back()->with('error', 'Tanggal awal dan akhir harus diisi.');
    }

    $tanggalAwal = Carbon::parse($tanggalAwal)->startOfDay();
    $tanggalAkhir = Carbon::parse($tanggalAkhir)->endOfDay();

    // Data manual
    $manualKeuangans = Keuangan::whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->select(
            'id',
            'tanggal',
            'jenis_transaksi',
            'keterangan',
            'jumlah',
            DB::raw("'manual' as sumber")
        );

    // Data dari pendaftaran program
    $pendaftaranKeuangans = DB::table('pendaftaran_programs')
        ->join('programs', 'pendaftaran_programs.tipe_program', '=', 'programs.id')
        ->where('pendaftaran_programs.status', 'diterima')
        ->whereBetween('pendaftaran_programs.created_at', [$tanggalAwal, $tanggalAkhir])
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
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->sum('jumlah');

    $totalPemasukanPendaftaran = PendaftaranProgram::where('status', 'diterima')
        ->whereBetween('created_at', [$tanggalAwal, $tanggalAkhir])
        ->sum('harga');

    $totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')
        ->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir])
        ->sum('jumlah');

    $totalSaldo = $totalPemasukanManual + $totalPemasukanPendaftaran - $totalPengeluaran;

    $pdf = Pdf::loadView('admin.keuangan.cetak', [
        'keuangans' => $keuangans,
        'totalPemasukanManual' => $totalPemasukanManual,
        'totalPemasukanPendaftaran' => $totalPemasukanPendaftaran,
        'totalPengeluaran' => $totalPengeluaran,
        'totalSaldo' => $totalSaldo,
        'tanggalAwal' => $tanggalAwal,
        'tanggalAkhir' => $tanggalAkhir,
    ]);

    return $pdf->download("laporan-keuangan-{$tanggalAwal->format('Ymd')}_to_{$tanggalAkhir->format('Ymd')}.pdf");
}



}
