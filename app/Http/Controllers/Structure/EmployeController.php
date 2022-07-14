<?php

namespace App\Http\Controllers\Structure;

use App\ApiRequest\Structure\EmployeApiRequest;
use App\Exceptions\NotAllowedException;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;
use App\Services\InscriptionService;
use App\Services\Structure\AffectationStructureService;
use App\Services\Structure\EmployeService;
use App\Shared\Controllers\BaseController;
use App\Traits\Structure\AuthorisationTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Swift_TransportException;

class EmployeController extends BaseController
{
    use AuthorisationTrait;
    protected $service;
    protected InscriptionService $inscriptionService;
    protected AffectationStructureService $affectationStructureService;
    protected $model = AffectationStructure::class;
    protected $validation = [
        'poste' => 'required|integer|exists:postes,id',
        'fonction' => 'required|integer|exists:fonctions,id',
        'structure' => 'required|integer|exists:structures,id',
        'role' => 'required|integer|exists:roles,id',
    ];


    public function __construct(EmployeService $employeService, InscriptionService $inscriptionService, AffectationStructureService $affectationStructureService)
    {
        parent::__construct($this->validation, $employeService);
        $this->inscriptionService = $inscriptionService;
        $this->affectationStructureService = $affectationStructureService;
    }

    public function getByStructure(EmployeApiRequest $request,  $structure)
    {
        return $this->service->getByStructure($request, $structure);
    }

    public function getResponsablesByStructure(Structure $structure)
    {
        return $structure->responsables()->get();
    }

    public function getChargeDeCourrierByStructure(Structure $structure)
    {
        return $structure->charges_de_courriers()->get();
    }

    public function store(Request $request)
    {
        $request->validate($this->validation);

        $this->inscriptionService->validate($request);


        try {
            $user = $this->inscriptionService->add($request);
        } catch (Swift_TransportException $e) {
            return $this->responseError('L\'email de confirmation n\'a pu être envoyé à l\'utilisteur. Veuillez ressayer ulterieurement.', 500);
        }

        $request->request->add(['user' => $user->id, 'inscription' => Auth::id()]);

        $affectation = $this->affectationStructureService->store($request->all());

        return $affectation->load(['poste', 'fonction', 'user', 'role']);
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->validation);

        // Update user details
        if ($request->has('prenom') && $request->has('email')) {
            $this->inscriptionService->validate($request);
            $this->inscriptionService->edit($request, $request->user);
        }

        return $this->service->update($id, $request->all());
    }


    public function validateEmploye(AffectationStructure $employe)
    {
        if (!$this->isAdmin(Auth::id(), $employe->structure)) {
            throw new NotAllowedException();
        }

        $employe = $this->service->validateEmploye($employe);

        return $employe->refresh();
    }


    public function show($id)
    {
        return $this->service->show($id);
    }
}
