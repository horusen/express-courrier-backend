<?php

namespace App\Http\Controllers\Structure;

use App\Exceptions\NotAllowedException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\InscriptionController;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Inscription;
use App\Models\Structure\Structure;
use App\Services\Structure\EmployeService;
use App\Shared\Controllers\BaseController;
use App\Traits\Structure\AdminTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Swift_TransportException;

class EmployeController extends BaseController
{
    use AdminTrait;
    protected $service;
    // Don't forget to extends BaseController
    protected $model = AffectationStructure::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];


    public function __construct(EmployeService $employeService)
    {
        parent::__construct($this->model, $this->validation);
        $this->service = $employeService;
    }

    public function getByStructure(Request $request, Structure $structure)
    {
        $status = $request->query('status');

        if (!isset($status) || !in_array($status, ['valid', 'unactivated', 'unverified'])) {
            $status = 'valid';
        }

        if ($status != 'valid') {
            if (!($this->isModerateur(Auth::id(), 10) || $this->isAdmin(Auth::id(), 10))) throw new NotAllowedException();
        }

        return $this->model::status($status)->where('structure', 10)->with(['fonction', 'poste', 'user'])->get();
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
        $request->validate([
            'fonction' => 'required|integer|exists:fonctions,id',
            'poste' => 'required|integer|exists:postes,id',
            'structure' => 'required|integer|exists:structures,id',
        ]);

        try {
            $user = (new InscriptionController())->store($request);
        } catch (Swift_TransportException $e) {
            return $this->responseError('L\'email de confirmation n\'a pu être envoyé à l\'utilisteur. Veuillez ressayer ulterieurement.', 500);
        }

        $request->request->add(['user' => $user->id, 'inscription' => Auth::id()]);

        $affectation = (new AffectationStructureController())->store($request);

        return $affectation->load(['poste', 'fonction', 'user']);
    }


    public function validateEmploye(AffectationStructure $employe)
    {
        if (!$this->isAdmin(Auth::id(), $employe->structure)) {
            throw new NotAllowedException();
        }

        $employe = $this->service->validateEmploye($employe);

        return $employe->refresh();
    }
}
