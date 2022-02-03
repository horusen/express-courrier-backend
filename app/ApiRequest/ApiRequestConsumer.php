<?php

namespace App\ApiRequest;

use Illuminate\Database\Eloquent\Builder;

trait ApiRequestConsumer
{
    public function scopeConsume(Builder $query, ApiRequest $apiRequest)
    {
        return $apiRequest->apply($query);
    }
}
