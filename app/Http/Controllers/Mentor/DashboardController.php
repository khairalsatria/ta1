<?php


// CONTROLLER: app/Http/Controllers/Mentor/DashboardController.php
namespace App\Http\Controllers\Mentor;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\KelasGenze;

class DashboardController extends Controller
{
    public function index()
{
    $kelas = KelasGenze::withCount('siswa')->where('mentor_id', Auth::id())->with('program')->get();
    return view('mentor.dashboard', compact('kelas'));
}


}
