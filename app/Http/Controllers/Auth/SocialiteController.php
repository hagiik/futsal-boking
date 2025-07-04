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

            // 1. Coba cari pengguna yang sudah ada berdasarkan provider dan provider_id
            $user = User::where('provider_name', $provider)
                        ->where('provider_id', $socialUser->getId())
                        ->first();

            // 2. Jika pengguna sudah ada, langsung gunakan data tersebut.
            if ($user) {
                // Tidak melakukan apa-apa ke database, karena pengguna sudah ada.
            } 
            // 3. Jika pengguna tidak ada, buat akun baru untuknya.
            else {
                // (Opsional tapi sangat disarankan: Cek duplikasi email)
                $existingUserWithEmail = User::where('email', $socialUser->getEmail())->first();

                if ($existingUserWithEmail) {
                    // Jika email sudah terdaftar (misal: via registrasi manual)
                    // Anda bisa memilih untuk menautkan akun atau menampilkan error.
                    // Untuk saat ini, kita tampilkan error untuk mencegah duplikasi.
                    return redirect('/login')->with('error', 'Email ini sudah terdaftar dengan metode lain. Silakan login dengan cara biasa.');
                }
                
                // Buat pengguna baru karena belum ada sama sekali
                $user = User::create([
                    'name'              => $socialUser->getName(),
                    'email'             => $socialUser->getEmail(),
                    'provider_name'     => $provider,
                    'provider_id'       => $socialUser->getId(),
                    'email_verified_at' => now(), // Diisi HANYA saat pembuatan
                ]);
            }

            // 4. Loginkan pengguna (baik yang lama maupun yang baru dibuat)
            Auth::login($user);

            // 5. Arahkan ke halaman dashboard
            return redirect('/');

        } catch (\Exception $e) {
            Log::error('Socialite Error: ' . $e->getMessage());
            return redirect('/login')->with('error', 'Gagal melakukan autentikasi dengan ' . $provider);
        }
    }
}