<?php

namespace App\Traits\Structure;

use App\Models\Structure\Admin;
use App\Models\Structure\Structure;

trait AdminTrait
{
    // Check if a given user is admin of a given strucuture
    protected function isAdmin($user, $structure)
    {
        $structure = $this->_getOldestAncestor($structure);


        $admin = Admin::where('user', $user)->where('structure', $structure->id)->where('type', 1)->first();



        return isset($admin);
    }

    protected function isModerateur($user, $structure)
    {
        $admin = Admin::where('user', $user)->where('structure', $structure)->first();

        return isset($admin);
    }





    protected function isSuperAdmin($user)
    {
        $admin = Admin::where('user', $user)->where('type', 1)->first();

        return isset($admin);
    }



    private function _getOldestAncestor($structure)
    {
        $structure = Structure::withDepth()->find($structure);

        if ($structure->depth == 0) return $structure;

        return $structure->ancestors()->withDepth()->having('depth', '=',  0)->first();
    }
}
