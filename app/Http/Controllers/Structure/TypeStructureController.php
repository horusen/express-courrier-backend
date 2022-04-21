<?php

namespace App\Http\Controllers\Structure;

use App\ApiRequest\ApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Structure\TypeStructure;
use App\Services\Structure\TypeStructureService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class TypeStructureController extends BaseController
{
    protected $model = TypeStructure::class;
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct(TypeStructureService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function all(ApiRequest $request)
    {
        return $this->model::consume($request);
    }
}
