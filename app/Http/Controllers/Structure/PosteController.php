<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Poste;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class PosteController extends BaseController
{
    protected $model = Poste::class;
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
