<?php

namespace App\Filters\Structure;

use App\Filters\Filter;

class StructureFilter extends Filter
{
    public function type($value = null)
    {
        return $this->builder->where('type', $value);
    }
}
