<?php

use App\Models\Messagerie\ExtensionFichier;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ExtensionFichierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        ExtensionFichier::create([
            'libelle' => 'mp3',
            'description' => $faker->text(),
            'type' => 1,
            'inscription' => 1
        ]);

        ExtensionFichier::create([
            'libelle' => 'mp4',
            'description' => $faker->text(),
            'type' => 2,
            'inscription' => 1
        ]);


        ExtensionFichier::create([
            'libelle' => 'pdf',
            'description' => $faker->text(),
            'type' => 4,
            'inscription' => 1
        ]);


        ExtensionFichier::create([
            'libelle' => 'jpg',
            'description' => $faker->text(),
            'type' => 3,
            'inscription' => 1
        ]);


        ExtensionFichier::create([
            'libelle' => 'png',
            'description' => $faker->text(),
            'type' => 3,
            'inscription' => 1
        ]);
    }
}
