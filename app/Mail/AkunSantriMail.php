<?php

namespace App\Mail;

use App\Models\Santri;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunSantriMail extends Mailable
{
    use Queueable, SerializesModels;

    public $santri, $data;
    /**
     * Create a new message instance.
     *
     * @param Santri $santri
     */
    public function __construct(Santri $santri, $data)
    {
        $this->santri = $santri;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.pendaftaran-santri')->subject('Pembuatan akun berhasil');
    }
}
