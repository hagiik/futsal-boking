<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
class ProfileController extends Controller
{

    public function show()
    {
        // $user = Auth::user();

        return view('pages.setting.profile');
    }
    /**
     * Menampilkan halaman profil pengguna dan riwayat pemesanannya.
     */
    public function showlist()
    {
        // 1. Ambil pengguna yang sedang login
        $user = Auth::user();

        // 2. Ambil booking milik user tersebut, dan lakukan Eager Loading
        //    untuk relasi 'field' dan 'field.category' agar efisien.
        //    Urutkan dari yang paling baru.
        $bookings = $user->bookings()
                         ->with(['field', 'field.category'])
                         ->latest()
                         ->paginate(5); // Ambil 5 data per halaman

        // 3. Kirim data ke view
        return view('livewire.settings.pesanan', compact('user', 'bookings'));
    }
}