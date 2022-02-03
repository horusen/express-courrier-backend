<?php

namespace App\Http\Controllers\Messagerie;

use App\ApiRequest\Messagerie\DiscussionApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messagerie\DiscussionRequest;
use App\Models\Messagerie\Discussion;
use App\Services\Messagerie\DiscussionService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends BaseController
{
    protected $model = Discussion::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];



    public function __construct(DiscussionService $service)
    {
        parent::__construct($this->model, $this->validation);
        $this->service = $service;
    }


    public function getByUser(DiscussionApiRequest $request)
    {
        return $this->service->getByUser($request, Auth::id());
    }

    public function getByStructure($structure)
    {
        $discussion = $this->service->getByStructure($structure);
        return response()->json($data = $discussion, $status = 200);
    }


    public function store(DiscussionRequest $request)
    {
        return $this->service->store($request->all());
    }

    public function check(DiscussionRequest $request)
    {

        return $this->service->getByCorrespondance($request->all());
    }

    public function delete(Discussion $discussion, $structure = null)
    {

        return $this->service->delete($discussion, $structure);
        // return null;
    }


    public function all()
    {
        return response()->json($this->model::all(), $status = 200);
    }


    public function show(Discussion $discussion)
    {
        return $discussion;
    }
}
