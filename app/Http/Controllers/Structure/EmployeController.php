<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class EmployeController extends BaseController
{

    // Don't forget to extends BaseController
    protected $model = AffectationStructure::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByStructure(Structure $structure)
    {
        return $this->model::with(['user', 'poste', 'fonction'])->where('structure', 8)->get();
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
