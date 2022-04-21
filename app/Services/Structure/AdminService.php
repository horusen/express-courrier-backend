<?php

namespace App\Services\Structure;

use App\Models\Structure\Admin;
use App\Services\BaseService;


class AdminService extends BaseService
{

    public function __construct(Admin $model)
    {
        parent::__construct($model);
    }
}
