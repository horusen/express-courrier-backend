<?php

namespace App\Services\Structure;

use App\Models\Structure\Fonction;
use App\Services\BaseService;


class FonctionService extends BaseService
{

    public function __construct(Fonction $model)
    {
        parent::__construct($model);
    }
}
