<?php

namespace App\Traits\Structure;

use App\Models\Structure\Admin;

trait AdminTrait
{
    // Check if a given user is admin of a given strucuture
    protected function isAdmin($user, $structure, $type_admin = 1)
    {
        $admin = Admin::where('user', $user)->where('structure', $structure)->where('type', $type_admin)->first();

        return isset($admin);
    }
}
