<?php

namespace App\Mail;

use App\Models\Courrier\CrCourrierEntrant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisDeRejetCourrierMail extends Mailable
{
    use Queueable, SerializesModels;
    public CrCourrierEntrant $courrier;
    public string $motif;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CrCourrierEntrant $courrier, string $motif)
    {
        $this->courrier = $courrier;
        $this->motif = $motif;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->subject("Avis de rejet de votre courrier. " . $this->courrier->libelle)
            ->markdown('mail.courrier.entrant.avis-de-rejet', ['url' => env('APP_URL') . '/courrier/entrant', 'courrier' => $this->courrier]);
    }
}
