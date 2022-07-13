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
