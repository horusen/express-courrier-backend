<?php

namespace App\Services\Structure;

use App\Models\Structure\AffectationStructure;
use App\Services\BaseService;
use App\Traits\Structure\AdminTrait;
use Exception;
use Illuminate\Support\Facades\Auth;

class AffectationStructureService extends BaseService
{
    use AdminTrait;

    public function __construct(AffectationStructure $model)
    {
        parent::__construct($model);
    }

    public function store($data)
    {

        if (!$this->isAdmin(Auth::id(), $data['structure'])) {
            throw new Exception("Non autorisé", 401);
        }

        return $this->model::create($data + ['inscription' => Auth::id()]);
    }
}
