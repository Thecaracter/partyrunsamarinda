<?php

namespace App\Mail;

use App\Models\Peserta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $peserta;

    public function __construct(Peserta $peserta)
    {
        $this->peserta = $peserta;
    }

    public function build()
    {
        return $this->subject('Konfirmasi Pembayaran - Party Color Run')
            ->view('emails.payment-notification');
    }
}