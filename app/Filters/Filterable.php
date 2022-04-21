<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    public function scopeFilter(Builder $query, Filter $filter)
    {
        return $filter->apply($query);
    }
}
