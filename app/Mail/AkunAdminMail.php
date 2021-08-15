<?php

namespace App\Mail;

use App\Models\Administrator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AkunAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin, $data;

    /**
     * Create a new message instance.
     *
     * @param Administrator $administrator
     * @param $data
     */
    public function __construct(Administrator $administrator, $data)
    {
        $this->admin = $administrator;
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.pendaftaran-admin')->subject('Pembuatan akun berhasil');
    }
}
