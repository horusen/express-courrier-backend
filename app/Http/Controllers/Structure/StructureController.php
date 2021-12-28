<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Admin;
use App\Models\Structure\Structure;
use App\Shared\Controllers\BaseController;
use App\Traits\Structure\StructureTrait;
use Illuminate\Http\Request;


class StructureController extends BaseController
{
    use StructureTrait;
    protected $model = Structure::class;
    protected $validation = [
        'libelle' => 'required',
        'type' => 'nullable|integer|exists:type_structures,id',
        'parent' => 'required|integer|exists:structures,id',
        'cigle' => 'required'
    ];

    public function index()
    {
        return $this->model::all();
    }


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function store(Request $request)
    {
        $this->isValid($request);

        // On verifie si le user connécté a les droits pour cree
        if ($request->has('parent') && $this->isAdmin($this->inscription, $request->parent)) {
            return $this->responseError("Non autorisé", 401);
        }

        $structure = $this->model::create($request->all() + ['inscription' => $this->inscription]);

        // On definit le nouveau membre comme administrateur
        Admin::create([
            'user' => $this->inscription,
            'structure' => $request->structure,
            'type' => 1,
            'inscription' => $this->inscription
        ]);

        return $structure;
    }

    public function show(Structure $structure)
    {
        return $structure->with('sous_structures')->first();
    }

    public function getSousStructures(Structure $structure)
    {
        return $structure->sous_structures()->get();
    }

    public function update(Request $request, Structure $structure)
    {
        $this->isValid($request);

        if (!$this->isAdmin($this->inscription, $request->structure)) {
            return $this->responseError("Non autorisé", 401);
        }

        $structure->update($request->all());
        return $structure->refresh();
    }

    public function destroy(Structure $structure)
    {
        if (!$this->isAdmin($this->inscription, $structure->id)) {
            return $this->responseError("Non autorisé", 401);
        }

        if ($this->hasEquipe($structure)) {
            return $this->responseError("Non autorisé: supprimez les personnes afféctés à cette structure", 401);
        }

        if ($this->hasSousStructure($structure)) {
            return $this->responseError("Non autorisé: supprimez les structures enfants de cette structure", 401);
        }

        $structure->delete();

        return $this->responseSuccess();
    }
}
