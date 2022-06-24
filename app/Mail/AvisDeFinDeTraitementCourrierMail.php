<?php

namespace App\Mail;

use App\Models\Courrier\CrCourrierEntrant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisDeFinDeTraitementCourrierMail extends Mailable
{
    use Queueable, SerializesModels;
    public CrCourrierEntrant $courrier;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CrCourrierEntrant $courrier)
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
            $this->subject("Avis de traitement de fin du courrier " . $this->courrier->cr_courrier->libelle)
            ->markdown('mail.courrier.entrant.avis-de-fin-de-traitement', ['url' => env('APP_URL') . '/courrier/entrant', 'courrier' => $this->courrier]);
    }
}
