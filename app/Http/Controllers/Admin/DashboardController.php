<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Kirim data ke view (contoh: total user, total order, dll.)
        $data = [
            'pageTitle' => 'Dashboard Admin',
            'totalUsers' => 150, // Contoh static, bisa ambil dari DB
            'totalOrders' => 75, // Contoh static
        ];

        return view('admin.dashboard', $data);
    }
}
