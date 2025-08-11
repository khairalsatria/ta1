<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PendaftaranProgram;
use App\Models\Keuangan;
use App\Models\Program;
use App\Models\KelasGenze;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function index()
{
    $totalPemasukanManual = Keuangan::where('jenis_transaksi', 'pemasukan')->sum('jumlah');
$totalPemasukanPendaftaran = PendaftaranProgram::where('status', 'diterima')->sum('harga');
$totalPengeluaran = Keuangan::where('jenis_transaksi', 'pengeluaran')->sum('jumlah');

$totalSaldo = $totalPemasukanManual + $totalPemasukanPendaftaran - $totalPengeluaran;

    $user = Auth::user(); // <--- Tambahkan ini
    $jumlahPendaftaran = PendaftaranProgram::count();
    $jumlahSiswa = User::where('role', 'user')->count();
    $jumlahMentor = User::where('role', 'mentor')->count();
    $jumlahKelas = KelasGenze::count();

    $siswaAktifPerKelas = KelasGenze::withCount(['siswa'])->get();

    $pendaftaranTerbaru = PendaftaranProgram::with(['user', 'program'])
        ->orderByDesc('created_at')
        ->limit(5)
        ->get();

    $pendaftaranBulanan = PendaftaranProgram::select(
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as bulan"),
            DB::raw('count(*) as total')
        )
        ->groupBy('bulan')
        ->orderBy('bulan')
        ->get();

    $chartLabels = $pendaftaranBulanan->pluck('bulan');
    $chartData = $pendaftaranBulanan->pluck('total');

    $pengunjungPerGender = User::select('gender', DB::raw('count(*) as total'))
        ->groupBy('gender')
        ->get();

    $jumlahLaki = User::where('role', 'user')->where('gender', 'Laki-laki')->count();
    $jumlahPerempuan = User::where('role', 'user')->where('gender', 'Perempuan')->count();

     
// Ambil jumlah pendaftaran per tipe program
$pendaftaranPerTipe = PendaftaranProgram::select('tipe_program', DB::raw('count(*) as total'))
    ->groupBy('tipe_program')
    ->pluck('total', 'tipe_program');

// Tipe program yang diinginkan, urut tetap
$tipeLabels = ['GenZE Class', 'GenZE Guide', 'GenZE Learn'];

// Ambil datanya, kalau tidak ada isi 0
$tipeData = [];
foreach ($tipeLabels as $tipe) {
    $tipeData[] = $pendaftaranPerTipe->get($tipe, 0);
}


    return view('admin.dashboard', compact(
        'user', // <--- Sertakan ini
        'jumlahPendaftaran',
        'jumlahSiswa',
        'jumlahMentor',
        'jumlahKelas',
        'siswaAktifPerKelas',
        'pendaftaranTerbaru',
        'chartLabels',
        'chartData',
        'pengunjungPerGender',
        'jumlahLaki',
        'jumlahPerempuan',
        'totalSaldo',
        'tipeLabels',
        'tipeData'
    ));
}

}
