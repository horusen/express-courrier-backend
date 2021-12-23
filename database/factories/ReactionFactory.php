<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Messagerie\Reaction;
use Faker\Generator as Faker;

$factory->define(Reaction::class, function (Faker $faker) {
    return [
        'reaction' => $faker->sentence($faker->numberBetween(5, 20)),
        'fichier' => null,
        'inscription' => $faker->numberBetween(1, 21),
        'discussion' => $faker->numberBetween(1, 10),
        'rebondissement' => null
    ];
});
