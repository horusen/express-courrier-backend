<?php

namespace App\Services\Messagerie;

use App\ApiRequest\Messagerie\ReactionApiRequest;
use App\Events\InboxMessageEvent;
use App\Events\MessageSentEvent;
use App\Exceptions\NotAllowedException;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
use App\Models\Messagerie\ReactionStructure;
use App\Models\Messagerie\ReactionSupprime;
use App\Services\BaseService;
use App\Traits\Messagerie\AutorisationDiscussionTrait;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ReactionService extends BaseService
{
    use AutorisationDiscussionTrait;


    public function __construct(Reaction $model)
    {
        parent::__construct($model);
    }

    // Marquer les elements comme dans un queue job
    public function getByDiscussion(ReactionApiRequest $request, $discussion, $structure = null)
    {
        // Definir une constante qui va representer le nombre de reactions
        // à recuperer pour chaque iteration
        $perIteration = 15;

        // Recuperer le nombre de reactions non-lu par l'utilisateur pour cette discussion
        $unreadedReactionsCount = $this->model::where('discussion', $discussion)->whereDoesntHave('reaction_lus', function ($q) {
            $q->where('user', Auth::id());
        })->count();


        // Si Le nombre de reactions non lu est superieur au nombre de reactions
        // A recuperer pour chaque iteration, on recupere toute les reactions non-lu
        // Si non on recupere juste le nombre de reactions predefini
        $reactions = [];
        $query = $this->model::where('discussion', $discussion)->whereNotDeleted()->latest();
        if ($perIteration >= $unreadedReactionsCount) {
            $reactions = $request->paginate($query, $perIteration, $request->page);
        } else {
            $reactions = $request->paginate($query, $unreadedReactionsCount, $request->page);
        }


        // Marquer toute les reactions de la discussion comme lu

        if ($structure) $this->marquerCommeLuParStructure($reactions->items(), $structure);
        else $this->marquerCommeLuParUser($reactions->items(), Auth::id());

        return $reactions;
    }

    public function marquerDiscussionLu($discussion)
    {
    }

    public function marquerCommeLuParUser($reactions)
    {
        foreach ($reactions as $reaction) {
            $reaction->marquerCommeLuParUser(Auth::id());
        }
    }

    public function marquerCommeLuParStructure($reactions, $structure)
    {
        foreach ($reactions as $reaction) {
            $reaction->marquerCommeLuByStructure($structure);
        }
    }


    public function store(array $data)
    {

        if (Arr::has($data, 'structure')) {
            if (
                !$this->isUserHasAutorisationFromStructure($data['structure'], Auth::id(), 'ecrire_messagerie') ||
                !$this->isStructureCorrespondantInDiscussion($data['discussion'], $data['structure'])
            )
                throw new NotAllowedException();
        } else {
            if (!$this->isUserCorrespondantInDiscussion($data['discussion'], Auth::id()))
                throw new NotAllowedException();
        }

        $file = null;
        if (Arr::has($data, 'fichier')) {
            $file = $data['fichier'];
            unset($data['fichier']);
        }

        $reaction = $this->model::create($data);


        if (Arr::has($data, 'structure')) $this->affecterReactionStructure($reaction, $data['structure']);

        if (isset($file)) {
            $reaction->update([
                'fichier' => $file->storeAs('discussion/' . $reaction->discussion . '/image', time() . '_' . Auth::id() . '_' . str_replace(' ', '_', $file->getClientOriginalName()), 'public')
            ]);
        }

        $this->touchDiscussion($reaction->discussion);

        broadcast(new MessageSentEvent($reaction))->toOthers();
        broadcast(new InboxMessageEvent(Discussion::find($reaction->discussion)))->toOthers();

        return $this->model::find($reaction->id);
    }


    public function delete(Reaction $reaction, $structure)
    {
        if ($structure) {
            if (
                $this->isStructureCorrespondantInDiscussion($reaction->discussion, $structure)
                && $this->isUserHasAutorisationFromStructure($structure, Auth::id(), 'ecrire_messagerie')
            ) {
                $this->deleteForStructure($reaction->id, $structure);
                return;
            }
        } else if (!$structure) {
            if ($this->isUserCorrespondantInDiscussion($reaction->discussion, Auth::id())) {
                $this->deleteForUser($reaction->id, Auth::id());
                return;
            }
        }

        throw new NotAllowedException();
    }


    private function affecterReactionStructure(Reaction $reaction, $structure)
    {
        ReactionStructure::create(['reaction' => $reaction->id, 'structure' => $structure, 'inscription' => Auth::id()]);
    }

    public function touchDiscussion($discussion)
    {
        return Discussion::find($discussion)->update(['touched_at' => Carbon::now()]);
    }

    public function deleteForUser($reaction, $user)
    {
        ReactionSupprime::create([
            'reaction' => $reaction,
            'user' => $user,
            'inscription' => Auth::id()
        ]);
    }

    public function deleteForStructure($reaction, $structure)
    {
        ReactionSupprime::create([
            'reaction' => $reaction,
            'structure' => $structure,
            'inscription' => Auth::id()
        ]);
    }
}
