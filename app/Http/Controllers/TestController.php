<?php

namespace App\Http\Controllers;

use App\Events\CourrierEvent;
use App\Events\CourrierTraiterEvent;
use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrReaffectation;

class TestController extends Controller
{
    public function sendCourrierEvent()
    {
        // $reaffectation = CrReaffectation::with(['cr_courrier', 'suivi_par'])->find(1);
        $courrier = CrCourrier::find(1);
        event(new CourrierTraiterEvent($courrier));
        return null;
    }
}
