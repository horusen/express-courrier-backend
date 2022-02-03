<?php

namespace App\Services\Messagerie;

use App\Actions\Messagerie\CreateReactionLuAction;
use App\ApiRequest\Messagerie\ReactionApiRequest;
use App\Exceptions\NotAllowedException;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
use App\Models\Messagerie\ReactionLu;
use App\Models\Messagerie\ReactionStructure;
use App\Models\Messagerie\ReactionSupprime;
use App\Traits\Messagerie\AutorisationDiscussionTrait;
use Carbon\Carbon;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ReactionService
{
    use AutorisationDiscussionTrait;

    // Marquer les elements comme dans un queue job
    public function getByDiscussion(ReactionApiRequest $request, $discussion, $structure = null)
    {

        return $reactions = Reaction::where('discussion', $discussion)->latest()->whereNotDeleted()->consume($request);

        $returned = $reactions->toArray();

        if ($structure) $this->marquerCommeLuParStructure($reactions, $structure);
        else $this->marquerCommeLuParUser($reactions, Auth::id());

        return $returned;
    }

    public function marquerCommeLuParUser($reactions)
    {
        foreach ($reactions as $reaction) {
            $reaction->marquerCommeLuByUser(Auth::id());
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
                !$this->isUserHasAutorisationFromStructure($data['structure'], Auth::id(), 'consulter_messagerie') ||
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

        $reaction = Reaction::create($data);


        if (Arr::has($data, 'structure')) $this->affecterReactionStructure($reaction, $data['structure']);

        if (isset($file)) {
            $reaction->update([
                'fichier' => $file->storeAs('discussion/' . $reaction->discussion . '/image', time() . '_' . Auth::id() . '_' . str_replace(' ', '_', $file->getClientOriginalName()), 'public')
            ]);
        }

        $this->touchDiscussion($reaction->discussion);

        return Reaction::find($reaction->id);
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
