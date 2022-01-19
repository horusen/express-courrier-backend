<?php

namespace App\Exceptions;

use Exception;

class NotAllowedException extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'Vous n\'êtes pas autorisé à effectuer cette action'], 403);
    }
}
