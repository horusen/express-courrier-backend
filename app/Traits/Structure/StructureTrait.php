<?php

namespace App\Traits\Structure;


use App\Models\Structure\Structure;

trait StructureTrait
{

    protected function hasSousStructure(Structure $structure)
    {
        return $structure->has('structure_enfants');
    }

    protected function hasEquipe(Structure $structure)
    {
        return $structure->has('affectation_structures');
    }
}
