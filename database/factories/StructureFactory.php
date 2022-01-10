<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\Structure;
use Faker\Generator as Faker;

$factory->define(Structure::class, function (Faker $faker) {

    return [
        'libelle' =>  "Service " . $faker->citySuffix(),
        'description' =>  $faker->text(),
        'cigle' => "SERVICE",
        'image' => 'images/service' . $faker->numberBetween(1, 5) . '.jpg',
        'type' =>  3,
        'parent_id' => $faker->numberBetween(2, 5),
        'inscription' =>  1,
    ];
});
