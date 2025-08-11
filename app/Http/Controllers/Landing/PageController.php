<?php

namespace App\Http\Controllers\Landing;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromosiClass;
use App\Models\Program;
use App\Models\User;
use App\Models\Kontak;
use App\Models\JenisKelas;
use App\Models\JenjangPendidikan;
use App\Models\JadwalKelas;
use App\Models\JadwalGuide2;
use App\Models\PaketGuide;
use App\Models\Testimonial;
use App\Models\Blog;
use App\Models\Faq;
use App\Models\MataPelajaran;



class PageController extends Controller
{

public function home()
{
    $blogs = Blog::all();
    $programs = Program::all();
    $mentors = User::where('role', 'mentor')->get();
    $kontaks = Kontak::all();
    $testimonials = Testimonial::with('user')->latest()->take(6)->get();
    $faqs = Faq::all(); // Ambil data dari database

    return view('landing.page.home', compact(
        'blogs',
        'programs',
        'mentors',
        'kontaks',
        'testimonials',
        'faqs' // Kirim ke blade
    ));
}



    public function about()
    {
        return view('landing.page.about');
    }
    public function detailCourse()
    {


        return view('landing.page.detail-course', compact('promosi_classes'));
    }
    public function program()
    {
        $programs = Program::paginate(6);
        return view('landing.page.program', compact('programs'));
    }

    public function detailProgram($program_id)
    {

        $jadwalGuide2 = JadwalGuide2::all();
        $paketGuides = PaketGuide::all();
    $programs = Program::all();
    $jenisKelas = JenisKelas::all();
    $jenjangPendidikans = JenjangPendidikan::all();
    $jadwalKelas = JadwalKelas::all();
   $program = Program::with('testimonials')->findOrFail($program_id);

    // $program = Program::where('tipe_program', 'GenZE Class')->firstOrFail();
    $relatedPrograms = Program::where('id', '!=', $program_id)->take(4)->get();
    return view('landing.page.detail-program', compact(
        'jenisKelas',
        'jenjangPendidikans',
        'jadwalKelas',
        'program',
        'relatedPrograms',
        'programs',
        'jadwalGuide2',
        'paketGuides'
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

   public function blog()
{
    $blogs = Blog::with('kategoriBlog')->latest('tanggal_posting')->paginate(6);
    return view('landing.page.blog', compact('blogs'));
}

public function detailBlog($id)
{
    $blog = Blog::with('kategoriBlog')->findOrFail($id);
    return view('landing.page.detail-blog', compact('blog'));
}

}
