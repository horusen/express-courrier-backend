<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use App\Shared\Controllers\BaseController;
use Illuminate\Support\Facades\Auth;

class NotificationController extends BaseController
{
    protected $validation = [
        'message' => 'required',
        'element' => 'required',
        'element_id' => 'required|integer',
        'user' => 'required|integer|exists:inscription,id'
    ];


    public function __construct(NotificationService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function getByUser()
    {
        return $this->service->getByUser(Auth::id());
    }
}
