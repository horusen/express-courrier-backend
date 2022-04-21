<?php

namespace App\ApiRequest\Structure;

use App\ApiRequest\ApiRequest;

class StructureApiRequest extends ApiRequest
{
    public function filter_by_type($builder, $value)
    {
        return $this->simpleFilter($builder, 'type', $value);
    }


    public function search($builder, $keyword)
    {
        return $builder->where('libelle', 'like', '%' . $keyword . '%')->orWhere('cigle', 'like', '%' . $keyword . '%');
    }
}
