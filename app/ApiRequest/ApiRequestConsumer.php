<?php

namespace App\ApiRequest;

use Illuminate\Database\Eloquent\Builder;

trait ApiRequestConsumer
{
    public function scopeFilter(Builder $query, ApiRequest $apiRequest)
    {
        return $apiRequest->apply($query);
    }
}
