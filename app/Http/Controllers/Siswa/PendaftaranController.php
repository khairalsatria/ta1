<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PendaftaranProgram;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;

class PendaftaranController extends Controller
{
    public function riwayat()
    {
        $riwayat = PendaftaranProgram::with('program')
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('siswa.pendaftaran.riwayat', compact('riwayat'));
    }

    public function status($id)
    {
        $userId = Auth::id();

        $pendaftaran = PendaftaranProgram::with([
                'program',
                'pendaftaranClass.jadwalKonfirmasi',
                'pendaftaranClass.jadwalAlternatif',
                'pendaftaranGuide.jadwalKonfirmasi',
                'pendaftaranLearn'
            ])
            ->where('id', $id)
            ->where('user_id', $userId)
            ->firstOrFail();

        return view('siswa.pendaftaran.status', compact('pendaftaran'));
    }
}
