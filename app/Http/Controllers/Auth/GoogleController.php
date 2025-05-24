<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'photo' => $googleUser->getAvatar(),
                    'role' => 'user',
                    'nohp' => null,
                    'password' => bcrypt('password-random-google'),
                ]);
            }

            Auth::login($user);

            return redirect()->intended('/home');
        } catch (\Exception $e) {
            dd($e);
            return redirect('/')->with('error', 'Gagal login dengan Google.');

        }
    }
}
