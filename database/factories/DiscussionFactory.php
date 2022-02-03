<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Messagerie\Discussion;
use Faker\Generator as Faker;

$factory->define(Discussion::class, function (Faker $faker) {
    static $type = 1;

    return [
        'inscription' => 1,
        'type' => $type++ < 24 ? 1 : 2
    ];
});
