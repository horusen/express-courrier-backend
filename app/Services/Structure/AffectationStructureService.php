<?php

namespace App\Services\Structure;

use App\Exceptions\NotAllowedException;
use App\Models\Structure\AffectationStructure;
use App\Services\BaseService;
use App\Traits\Structure\AuthorisationTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class AffectationStructureService extends BaseService
{
    use AuthorisationTrait;

    public function __construct(AffectationStructure $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {

        if (!$this->isAdmin(Auth::id(), $data['structure'])) {
            throw new NotAllowedException();
        }

        return $this->model::create($data + ['inscription' => Auth::id()]);
    }

    public function addUserToStructureAsAdmin($structure, $user)
    {
        return $this->model::create([
            'structure' => $structure,
            'role' => 2,
            'user' => $user,
            'activated_at' => Carbon::now(),
            'inscription' => Auth::id()
        ]);
    }
}
