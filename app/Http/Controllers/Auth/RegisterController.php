<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'nohp' => 'required|string|max:15|unique:users,nohp',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'nohp' => trim($request->nohp),
            'password' => Hash::make($request->password),
            'role' => 'user', // default role user biasa
        ]);

        Auth::login($user);

        return redirect()->route('home');
    }
}
