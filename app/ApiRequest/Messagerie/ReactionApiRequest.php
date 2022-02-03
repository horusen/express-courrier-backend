<?php

namespace App\ApiRequest\Messagerie;

use App\ApiRequest\ApiRequest;

class ReactionApiRequest extends ApiRequest
{


    public function search($keyword)
    {
        return $this->builder->where('reaction', 'like', '%' . $keyword . '%');
    }
}
