<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PendaftaranProgram;

class InvoicePendaftaranMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pendaftaran;

    public function __construct(PendaftaranProgram $pendaftaran)
    {
        $this->pendaftaran = $pendaftaran;
    }

    public function build()
    {
        $pdf = Pdf::loadView('pdf.invoice', ['pendaftaran' => $this->pendaftaran]);

        return $this->subject('Invoice Pembayaran Pendaftaran')
                    ->markdown('emails.invoice')
                    ->attachData($pdf->output(), 'Invoice-Pendaftaran.pdf');
    }
}
