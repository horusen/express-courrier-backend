<?php

namespace App\Http\Controllers\Authorization;

use App\Services\Authorization\RoleService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class RoleController extends BaseController
{
    protected $validation = [
        'libelle' => 'required',
        'structure' => 'required|integer|exists:structures,id',
        'authorisations' => 'required|array',
        'authorisations.*.scope' => 'required|integer|exists:scopes,id',
        'authorisations.*.authorisation' => 'required|in:"LECTURE","ECRITURE"',
    ];


    public function __construct(RoleService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function getByStructure($structure)
    {
        return $this->service->getByStructure($structure);
    }

    public function getAllByStructure($structure)
    {
        return $this->service->getAllByStructure($structure);
    }
}
