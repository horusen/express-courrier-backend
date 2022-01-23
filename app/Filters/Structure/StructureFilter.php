<?php

namespace App\Filters\Structure;

use App\Filters\Filter;

class StructureFilter extends Filter
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
