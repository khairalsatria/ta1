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
        $kelas = KelasGenze::where('mentor_id', Auth::id())->withCount('siswa')->get();
        return view('mentor.dashboard', compact('kelas'));
    }
}
