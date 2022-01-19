<?php

namespace App\Exceptions\Structure;

use Exception;

class UserAlreadyVerifiedException extends Exception
{
    public function render()
    {
        return response()->json(['message' => 'L\'utilisater a déjà validé son inscription'], 422);
    }
}
