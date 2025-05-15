<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\PendaftaranProgram;

class StatusPendaftaranController extends Controller
{
    public function index()
    {
        $pendaftarans = PendaftaranProgram::with([
            'program',
            'pendaftaranClass.jadwalKonfirmasi',
            'pendaftaranGuide.jadwalKonfirmasi',
            'pendaftaranLearn'
        ])
        ->where('user_id', Auth::id())
        ->latest()
        ->get();

        return view('siswa.pendaftaran.index', compact('pendaftarans'));
    }
}
