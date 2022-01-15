<?php

namespace App\Http\Controllers;

use App\ConditionsUtilisation;
use Illuminate\Http\Request;

class ConditionsUtilisationController extends Controller
{
    public function show()
    {
        return ConditionsUtilisation::first();
    }
}
