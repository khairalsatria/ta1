<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class SetPasswordController extends Controller
{
    public function showForm()
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login')->with('toast_error', 'Silakan login terlebih dahulu.');
        }

        return view('auth.set-password');
    }

   public function store(Request $request)
{
    $request->validate([
        'password' => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Pastikan ini akun Google yang perlu set password
    if (!$user->must_set_password) {
        return redirect()->route('landing.page.home')
            ->with('toast_error', 'Akun ini tidak memerlukan set password.');
    }

    // Simpan password baru dan matikan flag must_set_password
    $user->password = Hash::make($request->password);
    $user->must_set_password = false;
    $user->save();

    return redirect()->route('landing.page.home')
        ->with('toast_success', 'Password berhasil diset! Sekarang Anda bisa login manual.');
}

}
