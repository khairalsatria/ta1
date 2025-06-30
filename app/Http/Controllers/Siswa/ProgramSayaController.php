<?php

namespace App\Http\Controllers\Siswa;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;

class ProgramSayaController extends Controller
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


        return view('siswa.program-saya.index', compact('pendaftarans'));
    }
}


