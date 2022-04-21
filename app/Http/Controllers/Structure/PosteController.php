<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Poste;
use App\Services\Structure\PosteService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class PosteController extends BaseController
{
    protected $model = Poste::class;
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct(PosteService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function all()
    {
        return $this->model::all();
    }
}
