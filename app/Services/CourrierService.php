<?php

namespace App\Services;

use App\Models\Dash\CrCourrier;
use App\Services\BaseService;


class CourrierService extends BaseService
{

    public function __construct(CrCourrier $model)
    {
        parent::__construct($model);
    }


    public function getByUser($user)
    {
        return $this->model::where('suivi_par', $user)->orWhereHas('cr_reaffectations', function ($q) use ($user) {
            $q->where('suivi_par', $user);
        })->consume(null);
    }
}
