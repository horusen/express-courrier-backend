<?php

namespace App\Actions\Messagerie;

use App\Models\Messagerie\Reaction;
use App\Models\Messagerie\ReactionLu;
use Illuminate\Support\Facades\Auth;

class CreateReactionLuAction
{
    public static function byUser(Reaction $reaction, $user): ReactionLu
    {
        return ReactionLu::create([
            'reaction' => $reaction->id,
            'user' => $user,
            'inscription' => Auth::id()
        ]);
    }


    public static function byStructure(Reaction $reaction, $structure): ReactionLu
    {
        return ReactionLu::create([
            'reaction' => $reaction->id,
            'structure' => $structure,
            'inscription' => Auth::id()
        ]);
    }
}
