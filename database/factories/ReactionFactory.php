<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
use Faker\Generator as Faker;

$factory->define(Reaction::class, function (Faker $faker) {
    static $idDiscussion = 1;
    static $counter = 1;

    if ($counter % 50 == 0) $idDiscussion++;

    $discussion = Discussion::findOrFail($idDiscussion);


    if ($idDiscussion < 24)
        $inscription = $counter++ % 2 == 0 ? $discussion->correspondance_personne->user1 : $discussion->correspondance_personne->user2;
    else
        $inscription = $counter++ % 2 == 0 ? $discussion->correspondance_personne_structure->user : $discussion->correspondance_personne_structure->structure()->first()->charge_ecriture_messageries[0]->id;

    return [
        'reaction' => $faker->sentence($faker->numberBetween(5, 10)),
        'fichier' => null,
        'inscription' => $inscription,
        'discussion' => $idDiscussion,
        'rebondissement' => null
    ];
});
