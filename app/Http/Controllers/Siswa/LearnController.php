<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\PendaftaranLearns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LearnController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $id = $request->query('id');

        if ($id) {
            // Detail program tertentu
            $learn = PendaftaranLearns::with(['pendaftaran.program.genzeLearnEvent'])
                ->whereHas('pendaftaran', function ($q) use ($userId, $id) {
                    $q->where('user_id', $userId)
                      ->where('id', $id)
                      ->where('status', 'diterima');
                })
                ->firstOrFail();

            $event = $learn->pendaftaran->program->genzeLearnEvent ?? null;
            return view('siswa.program-saya.learn', [
                'detail' => true,
                'learn'  => $learn,
                'event'  => $event,
                'learns' => [] // kosongkan list
            ]);
        } else {
            // Daftar semua GenZE Learn
            $learns = PendaftaranLearns::with(['pendaftaran.program.genzeLearnEvent'])
                ->whereHas('pendaftaran', function ($q) use ($userId) {
                    $q->where('user_id', $userId)
                      ->where('status', 'diterima');
                })
                ->get();

            return view('siswa.program-saya.learn', [
                'detail' => false,
                'learns' => $learns,
                'learn'  => null,
                'event'  => null
            ]);
        }
    }

    public function downloadSertifikat($id)
    {
        $userId = Auth::id();

        $learn = PendaftaranLearns::with('pendaftaran')
            ->whereHas('pendaftaran', function ($q) use ($userId, $id) {
                $q->where('user_id', $userId)
                  ->where('id', $id)
                  ->where('status', 'diterima');
            })
            ->firstOrFail();

        if (!$learn->sertifikat || !Storage::disk('public')->exists($learn->sertifikat)) {
            return back()->with('error', 'Sertifikat belum tersedia.');
        }

        return response()->download(storage_path('app/public/' . $learn->sertifikat));
    }
}
