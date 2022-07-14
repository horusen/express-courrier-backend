<?php

namespace App\Services\Structure;

use App\ApiRequest\Structure\EmployeApiRequest;
use App\Exceptions\NotAllowedException;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;
use App\Services\BaseService;
use App\Traits\Structure\AuthorisationTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeService extends BaseService
{
    use AuthorisationTrait;

    public function __construct(AffectationStructure $model)
    {
        parent::__construct($model);
    }
    public function getByStructure(EmployeApiRequest $request,  $structure)
    {
        $status = $request->request->status;

        if (!isset($status) || !in_array($status, ['valid', 'unactivated', 'unverified'])) {
            $status = 'valid';
        }

        if ($status != 'valid') {
            if (!$this->isAdmin(Auth::id(), $structure)) throw new NotAllowedException();
        }

        return $this->model::status($status)->where('structure', $structure)->with(['fonction', 'poste', 'user', 'role'])->consume($request);
    }


    public function update($id, $data)
    {
        // Update affectation structure details
        $affectation = $this->model::findOrFail($id);
        $affectation->update(['poste' => $data['poste'], 'fonction' => $data['fonction'], 'role' => $data['role']]);

        // Return the value
        return $this->show($id);
    }


    public function validateEmploye($employe)
    {
        $employe->update(['activated_at' => Carbon::now()]);
        return $employe;
    }


    public function show($id)
    {
        return $this->model::with(['fonction', 'poste', 'user', 'structure:id,libelle,type', 'role'])->findOrFail($id);
    }
}
