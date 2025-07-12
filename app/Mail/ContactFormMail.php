<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactFormMail extends Mailable
{
    use Queueable, SerializesModels;

    public $details; // Properti untuk menampung data dari form

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        // Menerima data dari controller dan menyimpannya di properti 'details'
        $this->details = $details;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // Method ini membangun email
        return $this->subject('Pesan Baru Dari Formulir Kontak') // Subject email
                    ->view('emails.contact-form'); // View yang akan menjadi isi email
    }
}