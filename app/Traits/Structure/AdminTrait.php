<?php

namespace App\Traits\Structure;

use App\Models\Structure\Admin;

trait AdminTrait
{
    // Check if a given user is admin of a given strucuture
    protected function isAdmin($user, $structure, $type_admin = 2)
    {
        $admin = Admin::where(function ($query)  use ($user, $structure, $type_admin) {
            $query->where('user', $user)->where('structure', $structure)->where('type', $type_admin);
        })->orWhere(function ($query) use ($user) {
            $query->where('user', $user)->where('type', 1);
        })->first();

        return isset($admin);
    }


    protected function isSuperAdmin($user)
    {
        $admin = Admin::where('user', $user)->where('type', 1)->first();
        return isset($admin);
    }
}
