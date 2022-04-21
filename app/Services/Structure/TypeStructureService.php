<?php

namespace App\Services\Structure;

use App\Models\Structure\TypeStructure;
use App\Services\BaseService;


class TypeStructureService extends BaseService
{

    public function __construct(TypeStructure $model)
    {
        parent::__construct($model);
    }
}
