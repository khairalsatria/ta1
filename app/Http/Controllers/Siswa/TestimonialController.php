<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Program;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::where('user_id', Auth::id())->with('program')->latest()->get();
        return view('siswa.testimonial.index', compact('testimonials'));
    }

    public function create()
    {
        $programs = Program::all(); // bisa di-filter sesuai program yang diikuti user
        return view('siswa.testimonial.create', compact('programs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,id',
            'komentar' => 'required|string|max:1000',
            'rating' => 'required|integer|min:0|max:5',
        ]);

        Testimonial::create([
            'program_id' => $request->program_id,
            'user_id' => Auth::id(),
            'komentar' => $request->komentar,
            'rating' => $request->rating,
        ]);

        return redirect()->route('siswa.testimonial.index')->with('success', 'Testimonial berhasil dikirim.');
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        $testimonial->delete();
        return redirect()->back()->with('success', 'Testimonial berhasil dihapus.');
    }
}
