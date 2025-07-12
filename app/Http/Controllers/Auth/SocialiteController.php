<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman autentikasi provider.
     */
    public function redirectToProvider(string $provider)
    {
        // Validasi provider yang didukung
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        return Socialite::driver($provider)->redirect();
    }

    /**
     * Menangani callback dari provider setelah autentikasi.
     */
    public function handleProviderCallback(string $provider)
    {
        // Validasi provider yang didukung
        if (!in_array($provider, ['google', 'facebook'])) {
            abort(404);
        }

        try {
            $socialUser = Socialite::driver($provider)->user();

            $user = User::where('provider_name', $provider)
                        ->where('provider_id', $socialUser->getId())
                        ->first();

            if ($user) {

            } 

            else {

                $existingUserWithEmail = User::where('email', $socialUser->getEmail())->first();

                if ($existingUserWithEmail) {
                    return redirect('/login')->with('error', 'Email ini sudah terdaftar dengan metode lain. Silakan login dengan cara biasa.');
                }
                

                $user = User::create([
                    'name'              => $socialUser->getName(),
                    'email'             => $socialUser->getEmail(),
                    'provider_name'     => $provider,
                    'provider_id'       => $socialUser->getId(),
                    'email_verified_at' => now(), 
                ]);
            }


            Auth::login($user);


            return redirect('/');

        } catch (\Exception $e) {
            Log::error('Socialite Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal melakukan autentikasi dengan ' . $provider);
        }
    }
}