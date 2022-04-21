<?php

namespace App\Http\Controllers\Evenement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsereventController extends Controller
{
     public function getAlluserLikename($name)
    {
        return DB::table('inscription')
       ->where('telephone','=',$name)
       ->orWhere('nom','=',$name)
       ->orWhere('prenom','=',$name)
       ->get();
           
    }
}
