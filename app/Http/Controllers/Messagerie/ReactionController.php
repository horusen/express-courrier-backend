<?php

namespace App\Http\Controllers\Messagerie;

use App\ApiRequest\Messagerie\ReactionApiRequest;
use App\Http\Controllers\Controller;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
use App\Services\Messagerie\ReactionService;
use App\Shared\Controllers\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends BaseController
{
    // Don't forget to extends BaseController
    protected $model = Reaction::class;
    protected $validation = [
        // 'field_name' => 'field_validation'
    ];


    public function __construct(ReactionService $service)
    {
        parent::__construct($this->model, $this->validation);
        $this->service = $service;
    }


    public function getByDiscussion(ReactionApiRequest $request, $discussion)
    {
        return $this->service->getByDiscussion($request, $discussion);
    }


    public function store(Request $request)
    {
        $request->validate([
            'reaction' => 'required_without:fichier',
            'rebondissement' => 'integer|exists:reactions,id',
            'discussion' => 'required|integer|exists:discussions,id',
            'structure' => 'sometimes|integer|exists:structures,id',
            'fichier' => 'file|required_without:reaction'
        ]);

        return $this->service->store($request->all() + ['inscription' => Auth::id()]);
    }


    public function delete(Reaction $reaction, $structure = null)
    {
        return   $this->service->delete($reaction, $structure);
    }
}
