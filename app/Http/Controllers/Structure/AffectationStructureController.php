<?php

namespace App\Http\Controllers\Structure;

use App\Models\Structure\AffectationStructure;
use App\Services\Structure\AffectationStructureService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class AffectationStructureController extends BaseController
{
    protected $model = AffectationStructure::class;
    protected $validation = [
        'structure' => 'required|integer|exists:structures,id',
        'poste' => 'required|integer|exists:postes,id',
        'fonction' => 'required|integer|exists:fonctions,id',
        // 'is_responsable' => 'required|boolean',
        'user' => 'required|integer|exists:inscription,id',
    ];


    public function __construct(AffectationStructureService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function store(Request $request)
    {
        $this->isValid($request);

        return $this->service->store($request->all());
    }

    // public function update(Request $request, AffectationStructure $affectationStructure)
    // {
    //     $this->isValid($request);

    //     if (!$this->isAdmin($this->inscription, $request->structure)) {
    //         return $this->responseError("Non autorisé", 401);
    //     }

    //     $affectationStructure->update($request->all());

    //     return $affectationStructure->refresh();
    // }


    // public function destroy(AffectationStructure $affectationStructure)
    // {
    //     if (!$this->isAdmin($this->inscription, $affectationStructure->structure)) {
    //         return $this->responseError("Non autorisé", 401);
    //     }

    //     $affectationStructure->delete();

    //     return $this->responseSuccess();
    // }
}
