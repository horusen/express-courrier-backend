<?php

namespace App\Services\Structure;

use App\ApiRequest\ApiRequest;
use App\Models\Structure\Poste;
use App\Services\BaseService;


class PosteService extends BaseService
{

    public function __construct(Poste $model)
    {
        parent::__construct($model);
    }

    public function list(ApiRequest $request = null)
    {
        return $this->model::consume($request);
    }

    public function getByStructure($structure)
    {
        return $this->model::where('structure', $structure)->consume(null);
    }


    public function destroy($id)
    {
        $element = $this->model::findOrFail($id);
        if ($element->users()->first()) {
            return response()->json(['message' => 'Ce poste est lié à des utilisateurs. Supprimer d\'abord les utilisateurs.'], 422);
        }
        $element->delete();
        return null;
    }
}
