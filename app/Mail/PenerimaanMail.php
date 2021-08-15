<?php

namespace App\Mail;

use App\Models\Santri;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PenerimaanMail extends Mailable
{
    use Queueable, SerializesModels;

    public $santri;

    /**
     * Create a new message instance.
     *
     * @param Santri $santri
     */
    public function __construct(Santri $santri)
    {
        $this->santri = $santri;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Penerimaan Santri Baru')->view('mails.penerimaan');
    }
}
