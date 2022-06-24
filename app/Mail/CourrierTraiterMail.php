<?php

namespace App\Mail;

use App\Models\Courrier\CrCourrier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CourrierTraiterMail extends Mailable
{
    use Queueable, SerializesModels;

    private CrCourrier $courrier;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CrCourrier $courrier)
    {
        $this->courrier = $courrier;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->subject("Traitement du courrier " . $this->courrier->libelle)
            ->markdown('mail.inscription.courrier-traiter', ['url' => env('APP_URL') . '/courrier/entrant', 'courrier' => $this->courrier]);
    }
}
