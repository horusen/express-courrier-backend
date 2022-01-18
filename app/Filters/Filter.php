<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Http\Request;

abstract class Filter
{
    // Should be query params from request
    protected $query;

    // Builder instance
    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->filters = $request->except('search');
    }


    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;

        foreach ($this->filters as $name => $value) {
            if (method_exists($this, $name)) {
                call_user_func_array([$this, $name], [$value]);
            }
        }

        return $this->builder;
    }
}
