<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Structure\DroitAcces;
use Faker\Generator as Faker;

$factory->define(DroitAcces::class, function (Faker $faker) {

    static $number = 1;

    return [
        'libelle' => "niveau " . $number++,
        'description' => $faker->text,
        'inscription' => 1,
    ];
});
