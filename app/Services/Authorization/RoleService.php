<?php

namespace App\Services\Authorization;

use App\ApiRequest\ApiRequest;
use App\Models\Authorization\Role;
use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;

class RoleService extends BaseService
{
    private AuthorisationService $authorisationService;

    public function __construct(Role $model, AuthorisationService $authorisationService)
    {
        parent::__construct($model);
        $this->authorisationService = $authorisationService;
    }


    public function list(ApiRequest $request = null)
    {
        return $this->model::consume($request);
    }

    // Get role of the given structure including the default ones
    public function getAllByStructure($structure)
    {
        return $this->model::where('structure', $structure)->orWhereNull('structure')->get();
    }

    // Get only roles related to the given structure
    public function getByStructure($structure)
    {
        return $this->model::where('structure', $structure)->consume(null);
    }

    public function store(array $data)
    {
        $element = $this->model::create($data + ['inscription' => Auth::id()]);

        foreach ($data['authorisations'] as $authorisation) {
            $this->authorisationService->store(['role' => $element->id] + $authorisation);
        }

        return $this->model::find($element->id);
    }


    public function update(int $id, array $data)
    {
        $role = $this->model::findOrFail($id);

        $role->update($data);

        $this->authorisationService->deleteByRole($role->id);

        foreach ($data['authorisations'] as $authorisation) {
            $this->authorisationService->store(['role' => $role->id] + $authorisation);
        }

        return $role->refresh()->load('authorisations');
    }


    public function show($id)
    {
        return $this->model::with(['authorisations', 'users'])->find($id);
    }
}
