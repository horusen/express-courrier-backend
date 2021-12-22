<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\Inscription;
use Faker\Generator as Faker;

$factory->define(Inscription::class, function (Faker $faker) {
    return [
        'prenom' => $faker->firstName(),
        'nom' => $faker->lastName(),
        'identifiant' => $faker->numerify('identifiant-####'),
        'date_naissance' => $faker->date(),
        'lieu_naissance' => $faker->city(),
        'telephone' => $faker->unique()->phoneNumber(),
        'sexe' => $faker->randomElement(['HOMME', 'FEMME']),
        'inscription' => 1,

    ];
});
