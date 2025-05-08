<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromosiClass;
use App\Models\Program;
use App\Models\User;
use App\Models\Kontak;
use App\Models\JenisKelas;
use App\Models\JenjangPendidikan;
use App\Models\JadwalKelas;
use App\Models\MataPelajaran;



class PageController extends Controller
{

    public function home()
    {
        $programs = Program::all();
        $mentors = User::where('role', 'mentor')->get();
        $kontaks = Kontak::all(); // Mengambil semua data kontak
        return view('landing.page.home', compact('programs', 'mentors', 'kontaks'));
    }


    public function about()
    {
        return view('landing.page.about');
    }
    public function detailCourse()
    {
        $promosi_classes = PromosiClass::all();


        return view('landing.page.detail-course', compact('promosi_classes'));
    }
    public function program()
    {
        $programs = Program::paginate(6);
        return view('landing.page.program', compact('programs'));
    }

    public function detailProgram($program_id)
    {
    $jenisKelas = JenisKelas::all();
    $jenjangPendidikans = JenjangPendidikan::all();
    $jadwalKelas = JadwalKelas::all();
    $program = Program::findOrFail($program_id); // Program ID bisa 1 atau 6
    // $program = Program::where('tipe_program', 'GenZE Class')->firstOrFail();
    $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();
    return view('landing.page.detail-program', compact(
        'jenisKelas',
        'jenjangPendidikans',
        'jadwalKelas',
        'program',
        'relatedPrograms'
    ));
    }

    public function team()
    {
        $mentors = User::where('role', 'mentor')->get();
        return view('landing.page.team', compact('mentors'));
    }

    public function kontak()
    {
        return view('landing.page.kontak');
    }


}
