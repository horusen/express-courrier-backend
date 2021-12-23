<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Messagerie\IntervenantDiscussion;
use Faker\Generator as Faker;

$factory->define(IntervenantDiscussion::class, function (Faker $faker) {
    static $discussion = 1;
    return [
        'discussion' => $discussion++,
        'user1' => $faker->numberBetween(1, 21),
        'user2' => $faker->numberBetween(1, 21),
        'inscription' => 1,
    ];
});
