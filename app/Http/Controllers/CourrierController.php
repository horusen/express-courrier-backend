<?php

namespace App\Http\Controllers;

use App\Services\CourrierService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class CourrierController extends BaseController
{
    protected $validation = [];


    public function __construct(CourrierService $service)
    {
        parent::__construct($this->validation, $service);
    }

    public function getByUser($user)
    {
        return $this->service->getByUser($user);
    }
}
