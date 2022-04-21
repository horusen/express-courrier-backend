<?php

namespace App\Http\Controllers\Messagerie;

use App\ApiRequest\Messagerie\DiscussionApiRequest;
use App\Events\testev;
use App\Http\Controllers\Controller;
use App\Http\Requests\Messagerie\DiscussionRequest;
use App\Models\Messagerie\Discussion;
use App\Services\Messagerie\DiscussionService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends BaseController
{
    protected $validation = [
        'type' => 'required|integer|exists:type_discussions,id',
        'user1' => 'required_if:type,1|integer|exists:inscription,id',
        'user2' => 'required_if:type,1|integer|exists:inscription,id',
        'user' => 'required_if:type,2|integer|exists:inscription,id',
        'structure' => 'required_if:type,2|integer|exists:structures,id',
    ];



    public function __construct(DiscussionService $service)
    {
        parent::__construct($this->validation, $service);
    }


    public function getByUser(DiscussionApiRequest $request)
    {
        return $this->service->getByUser($request, Auth::id());
    }

    public function getByStructure(DiscussionApiRequest $request, $structure)
    {
        return $this->service->getByStructure($request, $structure);
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
        return response()->json(Discussion::all(), $status = 200);
    }
}
