<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Messagerie\CorrespondancePersonneStructure;
use Faker\Generator as Faker;

$factory->define(CorrespondancePersonneStructure::class, function (Faker $faker) {
    static $discussion = 4;

    if (!isset($discussion)) return;

    return [
        'user' => 1,
        'structure' => $faker->numberBetween(2, 6),
        'discussion' => $discussion++,
        'inscription' => 1
    ];
});
