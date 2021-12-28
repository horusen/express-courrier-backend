<?php

namespace App\Traits\Structure;

use App\Models\Structure\Admin;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;

trait StructureTrait
{

    // Check if a given user is admin of a given strucuture
    protected function isAdmin($user, $structure)
    {
        $admin = Admin::where('user', $user)->where('structure', $structure)->where('type', 1)->first();

        return isset($admin);
    }


    protected function hasSousStructure(Structure $structure)
    {
        return $structure->has('structure_enfants');
    }

    protected function hasEquipe(Structure $structure)
    {
        return $structure->has('affectation_structure');
    }
}
