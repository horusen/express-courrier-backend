<?php

namespace App\Services;

use App\Models\Structure\Inscription;

class AuthService
{
    public function sendConfirmationMail(Inscription $inscription)
    {
        $inscription->sendEmailVerificationNotification();
        return;
    }
}
