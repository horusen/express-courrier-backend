<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Fonction;
use App\Services\Structure\FonctionService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class FonctionController extends BaseController
{
    protected $model = Fonction::class;
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct(FonctionService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function all()
    {
        return $this->model::all();
    }
}
