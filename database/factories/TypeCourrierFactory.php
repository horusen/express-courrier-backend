<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Courrier\CrType;
use Faker\Generator as Faker;

$factory->define(CrType::class, function (Faker $faker) {
    return [
        'libelle' => $faker->word(),
        'description' => $faker->text(),
        'inscription' => 1
    ];
});
