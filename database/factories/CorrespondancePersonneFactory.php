<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Messagerie\CorrespondancePersonne;
use App\Models\Messagerie\Discussion;
use Faker\Generator as Faker;

$factory->define(CorrespondancePersonne::class, function (Faker $faker) {
    static $discussion = 1;

    if (!isset($discussion)) return;

    return [
        'user1' => 1,
        'user2' => $faker->numberBetween(2, 50),
        'discussion' => $discussion++,
        'inscription' => 1
    ];
});
