<?php

use App\Models\Structure\Structure;
use Faker\Factory;
use Illuminate\Database\Seeder;

class StructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $baseURL = 'http://localhost:8000';

        $faker = Factory::create();
        Structure::create([
            'libelle' => 'Ministère des eaux et de l\'assainissement',
            'cigle' => "MEA",
            'description' => $faker->text(),
            'image' => $baseURL . '/storage/images/ministere.png',
            'type' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'hydrolique',
            'cigle' => "DH",
            'image' => $baseURL . '/storage/images/DH.png',
            'description' => $faker->text(),
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'assainissement',
            'cigle' => "DA",
            'image' => $baseURL . '/storage/images/DA.png',
            'description' => $faker->text(),
            'type' => 2,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de la Planification et de la Gestion des Inondations',
            'cigle' => "DPGI",
            'image' => $baseURL . '/storage/images/1.png',
            'description' => $faker->text(),
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l’Administration Générale et de l’Equipement',
            'cigle' => "DAGE",
            'description' => $faker->text(),
            'image' => $baseURL . '/storage/images/2.jpg',
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);



        factory(Structure::class, 10)->create();
    }
}
