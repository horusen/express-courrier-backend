<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Courrier\CrUrgence;
use Faker\Generator as Faker;

$factory->define(CrUrgence::class, function (Faker $faker) {
    return [
        'libelle' => $faker->word(),
        'couleur' => $faker->hexColor(),
        'delai' => $faker->randomNumber(),
        'inscription' => 1
    ];
});
