<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\AffectationStructure;
use Faker\Generator as Faker;

$factory->define(AffectationStructure::class, function (Faker $faker) {
    static $user = 2;
    return [
        'user' => $user++,
        'structure' => $faker->numberBetween(7, 15),
        'fonction' => $faker->numberBetween(1, 7),
        'poste' => $faker->numberBetween(1, 10),
        'droit_acces' => $faker->numberBetween(1, 4),
        'inscription' => 1,
    ];
});
