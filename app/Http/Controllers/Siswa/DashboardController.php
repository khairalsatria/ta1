<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranProgram;
use App\Models\PendaftaranClasses;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Total program (semua tipe) dengan status menunggu
        $totalProgramMenunggu = PendaftaranProgram::where('user_id', $userId)
            ->where('status', 'menunggu')
            ->count();

        // Total program (semua tipe) dengan status diterima
        $totalProgramDiterima = PendaftaranProgram::where('user_id', $userId)
            ->where('status', 'diterima')
            ->count();

        /**
         * Total GenZE Class / Guide / Learn yang diikuti.
         * Biasanya “diikuti” berarti sudah diterima (status diterima / aktif).
         * Jika kamu punya status lain seperti 'aktif', tambahkan ke whereIn.
         * Sesuaikan nilai 'tipe_program' sesuai penyimpanan di database.
         * Contoh nilai: 'genze_class', 'genze_guide', 'genze_learn'
         */

        $statusDianggapIkut = ['diterima']; // atau ['diterima','aktif'] jika ada

       $statusDianggapIkut = ['diterima'];
$userId = Auth::id();

$totalGenzeClass = PendaftaranProgram::where('user_id', $userId)
    ->whereIn('status', $statusDianggapIkut)
    ->whereHas('program', function ($query) {
        $query->where('tipe_program', 'GenZE Class');
    })
    ->count();

$totalGenzeGuide = PendaftaranProgram::where('user_id', $userId)
    ->whereIn('status', $statusDianggapIkut)
    ->whereHas('program', function ($query) {
        $query->where('tipe_program', 'GenZE Guide');
    })
    ->count();

$totalGenzeLearn = PendaftaranProgram::where('user_id', $userId)
    ->whereIn('status', $statusDianggapIkut)
    ->whereHas('program', function ($query) {
        $query->where('tipe_program', 'GenZE Learn');
    })
    ->count();

$userId = Auth::id();

$jumlahKelasIkut = PendaftaranClasses::whereNotNull('kelas_id') // sudah tergabung di kelas_genze
    ->whereHas('pendaftaran', function($query) use ($userId) {
        $query->where('user_id', $userId)
              ->where('status', 'diterima'); // hanya kelas dengan status pendaftaran diterima
    })
    ->count();

        return view('siswa.dashboard', compact(
            'totalProgramMenunggu',
            'totalProgramDiterima',
            'totalGenzeClass',
            'totalGenzeGuide',
            'totalGenzeLearn',
            'jumlahKelasIkut'
        ));
    }
}
