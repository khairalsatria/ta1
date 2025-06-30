<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;
use App\Models\PendaftaranClasses;
use App\Models\JawabanSoalLatihan;

class DashboardController extends Controller
    {
        public function index(Request $request)
{
    $user = Auth::user();

    // Jumlah semua program
    $totalProgram = PendaftaranProgram::where('user_id', $user->id)->count();

    // Jumlah berdasarkan tipe program
    $jumlahClass = PendaftaranProgram::where('user_id', $user->id)
        ->whereHas('program', fn($q) => $q->where('tipe_program', 'Genze Class'))
        ->count();


    $jumlahGuide = PendaftaranProgram::where('user_id', $user->id)
        ->whereHas('program', fn($q) => $q->where('tipe_program', 'Genze Guide'))
        ->count();

    $jumlahLearn = PendaftaranProgram::where('user_id', $user->id)
        ->whereHas('program', fn($q) => $q->where('tipe_program', 'Genze Learn'))
        ->count();

    // Jumlah kelas yang sudah tergabung
    $jumlahKelasIkut = PendaftaranClasses::whereHas('pendaftaran', fn($q) =>
        $q->where('user_id', $user->id)
    )->count();

    return view('siswa.dashboard', compact(
        'totalProgram', 'jumlahClass', 'jumlahGuide',
        'jumlahLearn', 'jumlahKelasIkut'
    ));
}
    }
