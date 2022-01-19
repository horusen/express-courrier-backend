<?php

namespace App\Http\Controllers\Messagerie;

use App\Http\Controllers\Controller;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
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


    public function __construct()
    {
        parent::__construct($this->model, $this->validation);
    }


    public function getByDiscussion(Discussion $discussion)
    {
        return $this->model::where('discussion', $discussion->id)->get();
    }


    public function store(Request $request)
    {
        $request->validate(['reaction' => 'required', 'discussion' => 'required|integer|exists:discussions,id']);

        $reaction = $this->model::create($request->all() + ['inscription' => Auth::id()]);

        return $this->model::find($reaction->id);
    }
}
