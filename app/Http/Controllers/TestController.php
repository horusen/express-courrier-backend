<?php

namespace App\Http\Controllers;

use App\Events\CourrierEvent;
use App\Events\CourrierTraiterEvent;
use App\Mail\AvisDeFinDeTraitementCourrierMail;
use App\Mail\AvisDeReceptionCourrierMail;
use App\Mail\AvisDeReceptopn;
use App\Mail\AvisDeRejetCourrierMail;
use App\Mail\AvisDeTraitementCourrierMail;
use App\Mail\CourrierRecuMail;
use App\Mail\CourrierTraiterMail;
use App\Mail\ReaffectationCourrierMail;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use App\Models\Courrier\CrReaffectation;
use App\Notifications\CourrierTraiteNotification;
use Illuminate\Support\Facades\Mail;

class TestController extends Controller
{
    public function sendCourrierEvent()
    {
        $reaffectation = CrReaffectation::find(1);
        $courrier = CrCourrier::find(1);
        $courrierEntrant = CrCourrierEntrant::find(1);
        // event(new CourrierTraiterEvent($courrier));
        Mail::to($reaffectation->load(['suivi_par_inscription'])->suivi_par_inscription->email)->send(new ReaffectationCourrierMail($reaffectation));
    }
}
