<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Structure;
use Illuminate\Http\Request;

class EmployeController extends Controller
{
    public function getByStructure(Structure $structure)
    {
        return $structure->employes()->get();
    }

    public function getResponsablesByStructure(Structure $structure)
    {
        return $structure->responsables()->get();
    }

    public function getChargeDeCourrierByStructure(Structure $structure)
    {
        return $structure->charges_de_courriers()->get();
    }
}
