<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranClasses;

class MateriController extends Controller
{
   public function index()
{
    $pendaftaran = PendaftaranClasses::whereHas('pendaftaran', function ($q) {
        $q->where('user_id', Auth::id());
    })->with('kelas.materi')->first();

    $materi = collect(); // default kosong

    if ($pendaftaran && $pendaftaran->kelas && is_object($pendaftaran->kelas)) {
        $materi = $pendaftaran->kelas->materi->sortBy('pertemuan_ke');
    }

    return view('siswa.materi.index', compact('materi'));
}


}

