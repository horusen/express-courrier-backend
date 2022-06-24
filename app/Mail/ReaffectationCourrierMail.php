<?php

namespace App\Mail;

use App\Models\Courrier\CrReaffectation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReaffectationCourrierMail extends Mailable
{
    use Queueable, SerializesModels;

    public CrReaffectation $reaffectation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(CrReaffectation $reaffectation)
    {
        $this->reaffectation = $reaffectation->load(['cr_courrier', 'suivi_par_inscription', 'inscription']);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return
            $this->subject("Affectation du courrier " . $this->reaffectation->cr_courrier->libelle)
            ->markdown('mail.courrier.interne.reaffectation', ['url' => env('APP_URL') . '/courrier/entrant', 'reaffectation' => $this->reaffectation]);
    }
}
