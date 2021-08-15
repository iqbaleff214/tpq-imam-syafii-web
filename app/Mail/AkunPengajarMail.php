<?php

namespace App\Mail;

use App\Models\Pengajar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunPengajarMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajar, $data;

    /**
     * Create a new message instance.
     *
     * @param Pengajar $pengajar
     * @param $data
     */
    public function __construct(Pengajar $pengajar, $data)
    {
        $this->pengajar = $pengajar;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.pendaftaran-pengajar')->subject('Pembuatan akun berhasil');
    }
}
