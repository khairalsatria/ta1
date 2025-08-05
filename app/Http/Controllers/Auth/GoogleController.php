<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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

            // Cari user berdasarkan email
            $user = User::where('email', $googleUser->getEmail())->first();

            if ($user) {
                // Jika belum punya google_id, update supaya bisa login lewat Google berikutnya
                if (empty($user->google_id)) {
                    $user->update([
                        'google_id' => $googleUser->getId(),
                        'photo' => $googleUser->getAvatar(),
                    ]);
                }
            } else {
                // Buat user baru dari data Google
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'photo' => $googleUser->getAvatar(),
                    'role' => 'user',
                    'nohp' => null,
                    // password random karena login lewat Google
                    'password' => bcrypt(str()->random(16)),
                ]);
            }

            Auth::login($user);

            // Redirect berdasarkan role (mirip login controller)
            $redirect = match ($user->role) {
                'mentor' => route('mentor.dashboard'),
                'admin'  => route('admin.dashboard'),
                default  => route('landing.page.home'),
            };

            return redirect($redirect)->with('toast_success', 'Login berhasil menggunakan Google! Silakan pilih program.');
        } catch (\Exception $e) {
            Log::error('Google login error: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()
                ->route('landing.page.home')
                ->with('toast_error', 'Gagal login dengan Google. Silakan coba lagi.');
        }
    }
}
