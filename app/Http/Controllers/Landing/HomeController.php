<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PromosiClass;


class HomeController extends Controller
{
    public function home()
    {
        return view('landing.page.home');
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


}
