<?php

namespace App\Services;

use App\ApiRequest\ApiRequest;
use App\Notifications;
use App\Services\BaseService;


class NotificationService extends BaseService
{

    public function __construct(Notifications $model, ApiRequest $request)
    {
        parent::__construct($model, $request);
    }


    public function getByUser($user)
    {
        return $this->model::where('user', $user)->latest()->consume($this->apiRequest);
    }
}
