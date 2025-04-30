<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
{
    // Validasi input
    $request->validate([
        'login' => 'required|string', // Bisa email atau nohp
        'password' => 'required|string',
    ]);

    // Coba login berdasarkan email
    if (Auth::attempt(['email' => $request->login, 'password' => $request->password], $request->remember)) {
        // Cek role setelah login
        return $this->redirectBasedOnRole();
    }

    // Jika gagal dengan email, coba login berdasarkan nohp
    if (Auth::attempt(['nohp' => $request->login, 'password' => $request->password], $request->remember)) {
        // Cek role setelah login
        return $this->redirectBasedOnRole();
    }

    // Kalau tetap gagal, kembali ke form login
    return back()->withErrors([
        'login' => 'Email/No HP atau password tidak sesuai.',
    ])->withInput($request->only('login', 'remember'));
}

protected function redirectBasedOnRole()
{
    $role = Auth::user()->role;

    if ($role == 'user') {
        return redirect()->route('landing.page.home'); // Ganti dari 'home' ke 'landing.page.home'
    } elseif ($role == 'mentor') {
        return redirect()->route('mentor.dashboard');
    } elseif ($role == 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('landing.page.home'); // Default redirect
}



}
