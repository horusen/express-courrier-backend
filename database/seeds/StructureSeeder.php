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
            'image' => 'images/ministere.png',
            'type' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'hydrolique',
            'cigle' => "DH",
            'image' => 'images/DH.png',
            'description' => $faker->text(),
            'type' => 2,
            'parent_id' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'assainissement',
            'cigle' => "DA",
            'image' => 'images/DA.png',
            'description' => $faker->text(),
            'type' => 2,
            'parent_id' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de la Planification et de la Gestion des Inondations',
            'cigle' => "DPGI",
            'image' => 'images/1.png',
            'description' => $faker->text(),
            'type' => 2,
            'parent_id' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l’Administration Générale et de l’Equipement',
            'cigle' => "DAGE",
            'description' => $faker->text(),
            'image' => 'images/2.jpg',
            'type' => 2,
            'parent_id' => 1,
            'inscription' => 1
        ]);



        factory(Structure::class, 10)->create();
    }
}
