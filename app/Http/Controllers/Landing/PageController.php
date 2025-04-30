<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromosiClass;
use App\Models\Program;
use App\Models\User;
use App\Models\Kontak;


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


    public function detailProgram($id)
    {
        $program = Program::findOrFail($id);
        $relatedPrograms = Program::where('id', '!=', $id)->take(4)->get();
        return view('landing.page.detail-program', compact('program', 'relatedPrograms'));
    }


}
