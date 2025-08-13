<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // untuk request ke Google
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('landing.layout.navbar'); // ganti jika punya form register sendiri
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nohp' => 'required|string|max:15|unique:users,nohp',
            'password' => 'required|string|min:8|confirmed',
            'g-recaptcha-response' => 'required', // pastikan captcha ada
        ]);

        // Verifikasi ke Google
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json()['success']) {
            return back()->withInput()->with('error_register', 'Captcha tidak valid, coba lagi.');
        }

        try {
            $user = User::create([
                'name' => trim($request->name),
                'email' => trim($request->email),
                'nohp' => trim($request->nohp),
                'password' => Hash::make($request->password),
                'role' => 'user',
                'must_set_password' => false, // user manual sudah set password
            ]);

            return redirect()
                ->route('landing.page.home', ['login' => 'modal'])
                ->with('success_register', 'Registrasi berhasil! Silakan login untuk melanjutkan.');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error_register', 'Registrasi gagal. Silakan isi data dengan benar.');
        }
    }
}
