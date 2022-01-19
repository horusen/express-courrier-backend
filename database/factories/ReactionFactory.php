<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Messagerie\Discussion;
use App\Models\Messagerie\Reaction;
use Faker\Generator as Faker;

$factory->define(Reaction::class, function (Faker $faker) {
    $discussion = $faker->numberBetween(1, 6);
    static $inscription = 1;

    return [
        'reaction' => $faker->sentence($faker->numberBetween(5, 10)),
        'fichier' => null,
        'inscription' => $inscription++ % 2 == 0 ? Discussion::find($discussion)->intervenants->user1 : Discussion::find($discussion)->intervenants->user2,
        'discussion' => $discussion,
        'rebondissement' => null
    ];
});
