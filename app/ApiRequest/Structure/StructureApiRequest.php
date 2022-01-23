<?php

namespace App\ApiRequest\Structure;

use App\ApiRequest\ApiRequest;

class StructureApiRequest extends ApiRequest
{
    public function type($value = null, $operateur = '=')
    {
        return $this->builder->where('type', $operateur, $value);
    }


    public function search($keyword)
    {
        return $this->builder->where('libelle', 'like', '%' . $keyword . '%');
    }
}
