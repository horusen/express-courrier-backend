<?php

namespace App\Http\Controllers\Structure;

use App\Filters\Structure\StructureFilter as StructureStructureFilter;
use App\Filters\StructureFilter;
use App\Models\Structure\Admin;
use App\Models\Structure\Structure;
use App\Services\StructureService;
use App\Shared\Controllers\BaseController;
use App\Traits\Structure\AdminTrait;
use App\Traits\Structure\StructureTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StructureController extends BaseController
{
    use StructureTrait;
    use AdminTrait;
    // use FileHandlerTrait;
    protected $model = Structure::class;
    protected $validation = [
        'libelle' => 'required',
        'type' => 'required|integer|exists:type_structures,id',
        'parent_id' => 'nullable|integer|exists:structures,id',
        'cigle' => 'required'
    ];


    public function __construct(StructureService $service)
    {
        parent::__construct($this->model, $this->validation);
        $this->service = $service;
    }


    // public function all(StructureStructureFilter $request)
    // {
    //     // return ['test' => $request->query()];
    //     return $this->service->all($request);
    // }

    // recupere les structures où l'utilisateur est affecté
    public function index()
    {

        return Structure::whereHas('affectation_structures', function ($q) {
            $q->where('user', Auth::id());
        })->get();
    }





    // public function all()
    // {
    //     return $this->model::all();
    // }


    public function store(Request $request)
    {
        $this->isValid($request);


        $structure = $this->service->store($request->all());


        // On definit le nouveau membre comme moderateur
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

    public function getOldestAncestor(int $structure)
    {
        return Structure::withDepth()->with('sous_structures')->having('depth', '=', 0)->ancestorsAndSelf($structure);
    }

    public function getSousStructures(Structure $structure)
    {
        return $structure->sous_structures()->get();
    }


    public function getAutresStructures()
    {
        return Structure::whereDoesntHave('affectation_structures', function ($q) {
            $q->where('user', Auth::id());
        })->get();
    }


    public function getAllSousStructures(Structure $structure)
    {
        return $structure->descendants()->get();
    }


    public function getStructureEtSousStructures(int $structure)
    {
        return Structure::descendantsAndSelf($structure);
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
