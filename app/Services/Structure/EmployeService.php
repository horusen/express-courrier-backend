<?php

namespace App\Services\Structure;

use App\Exceptions\Structure\UserAlreadyVerifiedException;
use App\Models\Structure\AffectationStructure;
use App\Models\Structure\Inscription;
use App\Services\AuthService;
use App\Traits\Structure\AdminTrait;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class EmployeService
{
    use AdminTrait;


    public function validateEmploye($employe)
    {
        $employe->update(['activated_at' => Carbon::now()]);
        return $employe;
    }
}
