<?php

namespace App\Exceptions;

use Exception;

class ActionNotAllowedException extends Exception
{
    public function render($request)
    {
        return response()->json(['message' => "Vous n'êtes pas autorisé à effectuer cette action"], 401);
    }
}
