<?php


namespace App\ApiRequest\Structure;

use App\ApiRequest\ApiRequest;

class EmployeApiRequest extends ApiRequest
{
    public function search($builder, $keyword)
    {
        return $builder->whereHas('user', function ($q) use ($keyword) {
            $q->where('prenom', 'like', '%' . $keyword . '%')->orWhere('nom', 'like', '%' . $keyword . '%');
        });
    }
}
