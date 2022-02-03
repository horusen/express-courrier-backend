<?php

namespace App\Traits\Messagerie;

use App\Models\Courrier\CrAutorisationPersonneStructure;
use App\Models\Messagerie\Discussion;

trait AutorisationDiscussionTrait
{

    protected function isUserCorrespondantInDiscussion($discussion, $user)
    {
        $discussion = Discussion::whereCorrespondant($user)->find($discussion);

        return isset($discussion);
    }

    public function isStructureCorrespondantInDiscussion($discussion, $structure)
    {
        $discussion = Discussion::whereStructure($structure)->find($discussion);
        return isset($discussion);
    }


    public function isUserHasAutorisationFromStructure($structure, $user, string $autorisation)
    {
        if (!in_array($autorisation, ['ecrire_messagerie', 'consulter_messagerie'])) {
            abort(500, "Type autorisation doesnt exists");
        }

        $autorisation = CrAutorisationPersonneStructure::where('structure_id', $structure)
            ->where('personne_id', $user)
            ->where($autorisation, true)
            ->first();

        return isset($autorisation);
    }
}
