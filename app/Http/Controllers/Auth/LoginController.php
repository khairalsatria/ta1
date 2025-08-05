<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return redirect()->route('landing.page.home', ['login' => 'modal']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentialsEmail = ['email' => $request->login, 'password' => $request->password];
        $credentialsPhone = ['nohp' => $request->login, 'password' => $request->password];

        if (Auth::attempt($credentialsEmail, $request->remember) || Auth::attempt($credentialsPhone, $request->remember)) {
            return $this->redirectBasedOnRole()->with('success_login', 'Login berhasil! Silakan pilih program untuk didaftarkan.');
        }

        return redirect()
            ->back()
            ->withInput($request->only('login', 'remember'))
            ->with('error_login', 'Login gagal. Email/No HP atau password salah, silakan coba lagi.');
    }

    protected function redirectBasedOnRole()
    {
        $role = Auth::user()->role;

        if ($role == 'user') {
            return redirect()->route('landing.page.home');
        } elseif ($role == 'mentor') {
            return redirect()->route('mentor.dashboard');
        } elseif ($role == 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('landing.page.home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('landing.page.home')->with('success_logout', 'Anda telah berhasil logout.');
    }
}
