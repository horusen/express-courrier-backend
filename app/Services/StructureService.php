<?php

namespace App\Services;

use App\ApiRequest\ApiRequest;
use App\ApiRequest\Structure\StructureApiRequest;
use App\Exceptions\ActionNotAllowedException;

use App\Models\Structure\Structure;
use App\Traits\Structure\AuthorisationTrait;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use App\Models\Structure as StructureWDossier;

class StructureService extends BaseService
{
    use AuthorisationTrait;

    public function __construct(Structure $model)
    {
        parent::__construct($model);
    }

    public function list(ApiRequest $request = null)
    {
        return $this->model::whereHas('affectation_structures', function ($q) {
            $q->where('user', Auth::id());
        })->consume($request);
    }

    public function getAutresStructures(StructureApiRequest $request)
    {
        return $this->model::consume($request);
    }


    public function store($data)
    {
        // On verifie si le user connécté a les droits pour cree
        if (!$this->isSuperAdmin(Auth::id()) || !(Arr::has($data, 'parent_id') && $this->isAdmin(Auth::id(), $data['parent_id']))) {
            throw new ActionNotAllowedException();
        }


        $structure = $this->model::create($data + ['inscription' => Auth::id()]);

        if (Arr::has($data, 'image')) {
            $file = $data['image'];
            $structure->update(['image' => $file->storeAs('structure/' . $structure->id . '/image', $file->getClientOriginalName(), 'public')]);
        }

        return $structure->refresh();
    }


    public function getSousStructures(Structure $structure, StructureApiRequest $request)
    {
        return $structure->sous_structures()->consume($request);
    }

    public function getAllSousStructures(Structure $structure, StructureApiRequest $request)
    {
        return $structure->descendants()->consume($request);
    }

    public function getByUser(StructureApiRequest $request,  $user)
    {
        return $this->model::whereHas('_employes', function ($q) use ($user) {
            $q->where('inscription.id', $user);
        })->consume($request);
    }

    public function getByUserWDossier(StructureApiRequest $request,  $user)
    {
        return StructureWDossier::whereHas('_employes', function ($q) use ($user) {
            $q->where('inscription.id', $user);
        })->get();
    }
}
