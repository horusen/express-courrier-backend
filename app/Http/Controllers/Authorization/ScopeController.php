<?php

namespace App\Http\Controllers\Authorization;

use App\Services\Authorization\ScopeService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class ScopeController extends BaseController

{
    protected $validation = [
        'libelle' => 'required'
    ];


    public function __construct(ScopeService $service)
    {
        parent::__construct($this->validation, $service);
    }
}
