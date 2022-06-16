<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Courrier\CrMail;
use App\Models\Inscription;
use Faker\Generator as Faker;

$factory->define(CrMail::class, function (Faker $faker) {
    return [
        'libelle' => $faker->text,
        'contenu' => $faker->realText(10000),
        'draft' => 1,
        'inscription' => Inscription::inRandomOrder()->first()->id,
        'mail' => CrMail::inRandomOrder()->first()->id
    ];
});


$factory->afterCreating(CrMail::class, function ($mail, $faker) {
    $listInscription = Inscription::inRandomOrder()->limit(3)->get();
    $listInscription->each(function($item) use ($mail) {
        $mail->destinataire_personnes()->attach([$item->id => ['inscription_id'=> $item->id]]);
    });

    // $mail->destinataire_personnes()->attach([1 => ['inscription_id'=> 1]]);
});
