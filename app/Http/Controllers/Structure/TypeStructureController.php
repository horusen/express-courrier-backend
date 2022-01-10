<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\TypeStructure;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypeStructureController extends BaseController
{
    protected $model = TypeStructure::class;
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function all()
    {
        return $this->model::all();
    }
}
