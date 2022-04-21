<?php

namespace App\Services\Structure;

use App\Models\Structure\Poste;
use App\Services\BaseService;


class PosteService extends BaseService
{

    public function __construct(Poste $model)
    {
        parent::__construct($model);
    }
}
