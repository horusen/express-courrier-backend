<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;
use App\Shared\Controllers\BaseController;
use App\Traits\Structure\AdminTrait;
use Illuminate\Http\Request;

class AffectationStructureController extends BaseController
{
    use AdminTrait;
    protected $model = AffectationStructure::class;
    protected $validation = [
        'structure' => 'required|integer|exists:structures,id',
        'poste' => 'required|integer|exists:postes,id',
        'fonction' => 'required|integer|exists:fonctions,id',
        // 'is_responsable' => 'required|boolean',
        'user' => 'required|integer|exists:inscription,id',
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request)
    {
        $this->isValid($request);

        if (!$this->isAdmin($this->inscription, $request->structure)) {
            return $this->responseError("Non autorisé", 401);
        }

        return AffectationStructure::create($request->all() + ['inscription' => $this->inscription]);
    }

    public function update(Request $request, AffectationStructure $affectationStructure)
    {
        $this->isValid($request);

        if (!$this->isAdmin($this->inscription, $request->structure)) {
            return $this->responseError("Non autorisé", 401);
        }

        $affectationStructure->update($request->all());

        return $affectationStructure->refresh();
    }


    public function destroy(AffectationStructure $affectationStructure)
    {
        if (!$this->isAdmin($this->inscription, $affectationStructure->structure)) {
            return $this->responseError("Non autorisé", 401);
        }

        $affectationStructure->delete();

        return $this->responseSuccess();
    }
}
