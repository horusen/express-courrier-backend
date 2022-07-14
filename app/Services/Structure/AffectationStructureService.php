<?php

namespace App\Services\Structure;

use App\Exceptions\NotAllowedException;
use App\Models\Structure\AffectationStructure;
use App\Services\BaseService;
use App\Traits\Structure\AuthorisationTrait;
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
}
