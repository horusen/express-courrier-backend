<?php

namespace App\Traits\Structure;

use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Structure;

trait AuthorisationTrait
{
    // Check if a given user is admin of a given strucuture
    protected function isAdmin($user, $structure)
    {
        if ($this->isSuperAdmin($user)) return true;

        if (!isset($structure)) return false;

        // ID of the scope with the name structure
        $idScopeStructure = 11;

        $admin = AffectationStructure::where('user', $user)->where('structure', $structure)->where('role', 2)->orWhereHas('role.authorisations', function ($q) use ($idScopeStructure) {
            $q->where('scope', $idScopeStructure);
        })->first();
        return isset($admin);
    }







    protected function isSuperAdmin($user)
    {
        $admin = AffectationStructure::where('user', $user)->where('role', 1)->first();

        return isset($admin);
    }
}
