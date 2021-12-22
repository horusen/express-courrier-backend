<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\Fonction;
use Faker\Generator as Faker;

$factory->define(Fonction::class, function (Faker $faker) {
    return [
        'libelle' => ucfirst($faker->word()),
        'description' => $faker->text,
        'inscription' => 1,
    ];
});
