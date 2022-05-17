<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(Model::class, function (Faker $faker) {
    return [
        'libelle' => $faker->word(),
        'objet' => $faker->word(),
        'date_redaction' => $faker->date(),
        'nature_id' => $faker->numberBetween(1, 2),
        'type_id' => $faker->numberBetween(1, 5),
        'urgence_id' => $faker->numberBetween(1, 5),
        'structure_id' => $faker->numberBetween(1, 2),
    ];
});
