<?php

namespace App\Http\Controllers\Structure;

use App\ApiRequest\Structure\StructureApiRequest;
use App\Models\Structure\Structure;
use App\Services\Structure\AdminService;
use App\Services\Structure\AffectationStructureService;
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
    protected AdminService $adminService;
    protected $model = Structure::class;
    protected AffectationStructureService $affectationStructureService;
    protected $validation = [
        'libelle' => 'required',
        'type' => 'required|integer|exists:type_structures,id',
        'parent_id' => 'nullable|integer|exists:structures,id',
        'cigle' => 'required'
    ];


    public function __construct(StructureService $service, StructureApiRequest $apiRequest, AffectationStructureService $affectationStructureService, AdminService $adminService)
    {
        parent::__construct($this->validation, $service, $apiRequest);
        $this->affectationStructureService = $affectationStructureService;
        $this->adminService = $adminService;
    }


    // public function all(StructureStructureFilter $request)
    // {
    //     // return ['test' => $request->query()];
    //     return $this->service->all($request);
    // }

    // recupere les structures où l'utilisateur est affecté
    public function index()
    {
        return $this->service->list($this->apiRequest);
    }





    public function all(StructureApiRequest $request)
    {
        return $this->model::consume($request);
    }


    public function store(Request $request)
    {
        $request->validate($this->validation);


        $structure = $this->service->store($request->all());



        // On definit le nouveau membre comme moderateur
        $this->adminService->store([
            'user' => Auth::id(),
            'structure' => $structure->id,
            'type' => 2,
            'inscription' => Auth::id()
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

    public function getSousStructures(Structure $structure, StructureApiRequest $request)
    {
        return $this->service->getSousStructures($structure, $request);
    }


    public function getAutresStructures(StructureApiRequest $apiRequest)
    {

        return $this->service->getAutresStructures($apiRequest);
    }


    public function getAllSousStructures(Structure $structure, StructureApiRequest $request)
    {
        return $this->service->getAllSousStructures($structure, $request);
    }


    public function getStructureEtSousStructures(int $structure)
    {
        return Structure::descendantsAndSelf($structure);
    }

    public function update(Request $request,  $id)
    {
        $request->validate($this->validation);

        $structure = Structure::findOrFail($id);

        if (!$this->isAdmin(Auth::id(), $request->structure)) {
            return $this->responseError("Non autorisé", 401);
        }

        $structure->update($request->except('image'));
        return $structure->refresh();
    }

    public function destroy($id)
    {
        $structure = Structure::findOrFail($id);

        if (!$this->isAdmin(Auth::id(), $structure->id)) {
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

    public function getByUser(StructureApiRequest $request, $user)
    {
        return $this->service->getByUser($request, $user);
    }
}
