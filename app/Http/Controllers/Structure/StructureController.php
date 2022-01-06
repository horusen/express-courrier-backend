<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure\Admin;
use App\Models\Structure\Structure;
use App\Shared\Controllers\BaseController;
use App\Traits\FileHandlerTrait;
use App\Traits\Structure\AdminTrait;
use App\Traits\Structure\StructureTrait;
use Illuminate\Http\Request;


class StructureController extends BaseController
{
    use StructureTrait;
    use AdminTrait;
    // use FileHandlerTrait;
    protected $model = Structure::class;
    protected $validation = [
        'libelle' => 'required',
        'type' => 'nullable|integer|exists:type_structures,id',
        'parent' => 'required|integer|exists:structures,id',
        'cigle' => 'required'
    ];

    // TODO: COrriger la recuperation de la structure à partir des informations de l'utilisateur connécté
    public function index()
    {
        return [Structure::find(1)->load('sous_structures')];
    }


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function all()
    {
        return $this->model::all();
    }


    public function store(Request $request)
    {
        $this->isValid($request);


        // On verifie si le user connécté a les droits pour cree
        if ($request->has('parent') && $this->isAdmin($this->inscription, $request->parent)) {
            return $this->responseError("Non autorisé", 401);
        }


        $structure = $this->model::create($request->all() + ['inscription' => $this->inscription]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $structure->update(['image' => $file->storeAs('structure/' . $structure->id . '/image', $file->getClientOriginalName(), 'public')]);
        }

        // On definit le nouveau membre comme administrateur
        Admin::create([
            'user' => $this->inscription,
            'structure' => $structure->id,
            'type' => 2,
            'inscription' => $this->inscription
        ]);

        return $structure;
    }

    public function show(int $structure)
    {
        return Structure::withDepth()->findOrFail($structure)->load(['sous_structures' => function ($q) {
            $q->withDepth();
        }])->append(['charge_courriers', 'employes', 'responsable']);
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

        $structure->update($request->except('image'));
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
