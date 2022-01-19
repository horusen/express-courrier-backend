<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use App\Models\Messagerie\Discussion;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;

class DiscussionController extends BaseController
{
    // Don't forget to extends BaseController
    protected $model = Discussion::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function all()
    {
        return $this->model::all();
    }


    public function show(Discussion $discussion)
    {
        return $discussion;
    }
}
