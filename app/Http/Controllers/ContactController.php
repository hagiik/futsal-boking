<?php

namespace App\Http\Controllers;

use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail; // Pastikan untuk mengimpor Mail

class ContactController extends Controller
{
    // Method untuk menampilkan halaman
    public function index()
    {
        return view('pages.home.contact');
    }

    // Method untuk memproses formulir
    public function store(Request $request)
    {
        // 1. Validasi data
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // 2. Di sini Anda bisa menambahkan logika untuk:
        //    - Mengirim email notifikasi ke admin
        //    - Menyimpan pesan ke database

        // Contoh: 
        Mail::to('hagiihsank@gmail.com')->send(new ContactFormMail($validated));

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Pesan Anda telah berhasil terkirim! Terima kasih.');
    }
}