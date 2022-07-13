<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\AffectationStructure;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(AffectationStructure::class, function (Faker $faker) {
    static $user = 2;
    return [
        'user' => $user++,
        'structure' => $faker->numberBetween(7, 15),
        'fonction' => $faker->numberBetween(1, 7),
        'poste' => $faker->numberBetween(1, 10),
        'role' => 3,
        'inscription' => 1,
        'activated_at' => $faker->optional(0.5)->dateTime()
    ];
});
