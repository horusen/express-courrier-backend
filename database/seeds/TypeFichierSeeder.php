<?php

use App\Models\Messagerie\TypeFichier;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TypeFichierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        TypeFichier::create([
            'libelle' => 'AUDIO',
            'description' => $faker->text(),
            'inscription' => 1
        ]);

        TypeFichier::create([
            'libelle' => 'VIDEO',
            'description' => $faker->text(),
            'inscription' => 1
        ]);


        TypeFichier::create([
            'libelle' => 'IMAGE',
            'description' => $faker->text(),
            'inscription' => 1
        ]);


        TypeFichier::create([
            'libelle' => 'DOCUMENT',
            'description' => $faker->text(),
            'inscription' => 1
        ]);
    }
}
