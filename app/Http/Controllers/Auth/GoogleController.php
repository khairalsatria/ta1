<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Hash;

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

        if ($user) {
            // Jika belum punya google_id, update
            if (empty($user->google_id)) {
                $user->update([
                    'google_id' => $googleUser->getId(),
                    'photo'     => $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Buat user baru dengan password random
            $user = User::create([
                'name'              => $googleUser->getName(),
                'email'             => $googleUser->getEmail(),
                'google_id'         => $googleUser->getId(),
                'photo'             => $googleUser->getAvatar(),
                'role'              => 'user',
                'nohp'              => null,
                'password'          => bcrypt(str()->random(16)), // random password
                'must_set_password' => true,
            ]);
        }

        Auth::login($user);

        // Cek apakah harus set password
        if ($user->must_set_password) {
            return redirect()->route('user.set.password.form')
                ->with('toast_info', 'Silakan buat password agar bisa login manual di lain waktu.');
        }

        // Redirect sesuai role
        $redirect = match ($user->role) {
            'mentor' => route('mentor.dashboard'),
            'admin'  => route('admin.dashboard'),
            default  => route('landing.page.home'),
        };

        return redirect($redirect)
            ->with('toast_success', 'Login berhasil menggunakan Google!');
    } catch (\Exception $e) {
        Log::error('Google login error: '.$e->getMessage(), [
            'trace' => $e->getTraceAsString(),
        ]);

        return redirect()
            ->route('landing.page.home')
            ->with('toast_error', 'Gagal login dengan Google. Silakan coba lagi.');
    }
}


    /**
     * Cek apakah password masih random (tidak bisa dicek langsung nilainya,
     * tapi kita bisa akali dengan membandingkan pola tertentu jika ada).
     * Sementara ini, kita selalu anggap user Google yang belum pernah set password
     * diarahkan ke form.
     */
    private function isRandomPassword($hashedPassword)
    {
        // Di sini kita tidak bisa tahu pasti karena hash selalu unik,
        // jadi fungsi ini bisa diganti dengan logika cek kolom lain kalau mau.
        return true;
    }
}
