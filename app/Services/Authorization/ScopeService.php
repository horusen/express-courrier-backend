<?php


namespace App\Services\Authorization;

use App\Models\Authorization\Scope;
use App\Services\BaseService;


class ScopeService extends BaseService
{

    public function __construct(Scope $model)
    {
        parent::__construct($model);
    }
}
