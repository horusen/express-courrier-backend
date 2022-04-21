<?php

namespace App\Services\Messagerie;

use App\ApiRequest\Messagerie\DiscussionApiRequest;
use App\Exceptions\NotAllowedException;
use App\Models\Messagerie\CorrespondancePersonne;
use App\Models\Messagerie\CorrespondancePersonneStructure;
use App\Models\Messagerie\DeletedDiscussion;
use App\Models\Messagerie\Discussion;
use App\Services\BaseService;
use App\Traits\Messagerie\AutorisationDiscussionTrait;
use Carbon\Carbon;
use CreateDossierTable;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionService extends BaseService
{

    use AutorisationDiscussionTrait;

    public function __construct(Discussion $model)
    {
        parent::__construct($model);
    }



    /***
     *
     *
     * PUBLIC
     *
     */
    public function getByUser(DiscussionApiRequest $request, $user)
    {
        return $this->model::whereNotDeleted($user)
            ->whereCorrespondant($user)
            ->whereReaction()
            ->orderBy('touched_at', 'DESC')
            ->consume($request);
    }

    public function getByStructure(DiscussionApiRequest $request, $structure)
    {
        if (!$this->isUserHasAutorisationFromStructure($structure, Auth::id(), 'consulter_messagerie'))
            abort(401, "Vous n'êtes pas autorisé à effectuer cette action");

        return $this->model::whereNotDeletedStructure($structure)
            ->whereStructure($structure)
            ->whereReaction()
            ->orderBy('touched_at', 'DESC')
            ->consume($request);
    }


    public function store(array $data)
    {
        $correspondants = $this->defineCorrespondants($data);

        if ($this->isDiscussionExists($data['type'], $correspondants[0], $correspondants[1])) {
            abort(422, "La discussion existe déjà");
        }

        $discussion = $this->model::create(['type' => $data['type'], 'inscription' => Auth::id(), 'touched_at' => Carbon::now()]);

        $this->createCorrespondance($data['type'], $discussion->id, $correspondants);

        return $discussion->refresh();
    }


    // public function show(int $id)
    // {
    //     return $this->model::with(['affectation_structure.poste', 'affectation_structure.fonction'])->findOrFail($id);
    // }


    public function delete(Discussion $discussion, $structure)
    {
        if ($discussion->type == 2 && !$structure) {
            abort(400, "Donnée ambigue, verifiez votre url");
        }

        if ($structure) {
            if (
                $this->isStructureCorrespondantInDiscussion($discussion->id, $structure)
                && $this->isUserHasAutorisationFromStructure($structure, Auth::id(), 'ecrire_messagerie')
            ) {
                $this->deleteDiscussionForStructure($discussion->id, $structure);
                return;
            }
        } else if (!$structure) {
            if ($this->isUserCorrespondantInDiscussion($discussion->id, Auth::id())) {
                $this->deleteDiscussionForUser($discussion->id, Auth::id());
                return;
            }
        }

        throw new NotAllowedException();
    }


    public function getByCorrespondance($data)
    {
        if ($data['type'] == 1) {
            $discussion = $this->getDiscussionPersonnes($data['user1'], $data['user2']);
        } else if ($data['type'] == 2) {
            $discussion =  $this->getDiscussionPersonneStructure($data['user'], $data['structure']);
        } else {
            abort(422, "Données ambigues");
        }


        return isset($discussion) ? $discussion : $this->store($data);
    }




    /***
     *
     *
     * PRIVATE
     *
     */

    private function isDiscussionExists(int $type, int $correspondant, int $autre_correspondant): bool
    {
        if ($type == 1) return $this->isDiscussionPersonnesExists($correspondant, $autre_correspondant);
        else if ($type == 2) return $this->isDiscussionPersonneStructureExists($correspondant, $autre_correspondant);


        return false;
    }

    private function isDiscussionPersonnesExists($correspondant, $autre_correspondant): bool
    {
        $discussion = $this->getDiscussionPersonnes($correspondant, $autre_correspondant);
        return isset($discussion);
    }

    private function isDiscussionPersonneStructureExists($personne, $structure)
    {
        $discussion = $this->getDiscussionPersonneStructure($personne, $structure);
        return isset($discussion);
    }

    public function getDiscussionPersonnes($correspondant, $autre_correspondant)
    {
        return  $this->model::whereCorrespondants($correspondant, $autre_correspondant)->first();
    }


    public function getDiscussionPersonneStructure($personne, $structure)
    {
        return  $this->model::whereCorrespondantStructure($personne, $structure)->first();
    }



    private function defineCorrespondants($data)
    {
        $correspondant = null;
        $autre_correspondant = null;

        if ($data['type'] == 1) {
            $correspondant = $data['user1'];
            $autre_correspondant = $data['user2'];
        } else if ($data['type'] == 2) {
            $correspondant = $data['user'];
            $autre_correspondant = $data['structure'];
        }

        return [$correspondant, $autre_correspondant];
    }


    private function createCorrespondance(int $type_discussion, int $discussion, array $correspondants)
    {
        if ($type_discussion == 1) {
            CorrespondancePersonne::create([
                'user1' => $correspondants[0],
                'user2' => $correspondants[1],
                'discussion' => $discussion,
                'inscription' => Auth::id()
            ]);
        } else if ($type_discussion == 2) {
            CorrespondancePersonneStructure::create([
                'user' => $correspondants[0],
                'structure' => $correspondants[1],
                'discussion' => $discussion,
                'inscription' => Auth::id()
            ]);
        }
    }



    public function deleteDiscussionForUser($discussion, $user)
    {
        DeletedDiscussion::create([
            'discussion' => $discussion,
            'user' => $user,
            'inscription' => Auth::id()
        ]);
    }

    public function deleteDiscussionForStructure($discussion, $structure)
    {
        DeletedDiscussion::create([
            'discussion' => $discussion,
            'structure' => $structure,
            'inscription' => Auth::id(),
        ]);
    }
}
