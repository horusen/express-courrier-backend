<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Http\Controllers\InscriptionController;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Swift_TransportException;

class EmployeController extends BaseController
{

    // Don't forget to extends BaseController
    protected $model = AffectationStructure::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }

    public function getByStructure(Structure $structure)
    {
        return $this->model::with(['user', 'poste', 'fonction'])->where('structure', 8)->get();
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
}
