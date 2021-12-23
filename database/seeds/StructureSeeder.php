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
        $faker = Factory::create();
        Structure::create([
            'libelle' => 'Ministère des eaux et de l\'assainissement',
            'cigle' => "MEA",
            'description' => $faker->text(),
            'type' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'hydrolique',
            'cigle' => "DH",
            'description' => $faker->text(),
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l\'assainissement',
            'cigle' => "DA",
            'description' => $faker->text(),
            'type' => 2,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de la Planification et de la Gestion des Inondations',
            'cigle' => "DPGI",
            'description' => $faker->text(),
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);

        Structure::create([
            'libelle' => 'Direction de l’Administration Générale et de l’Equipement',
            'cigle' => "DAGE",
            'description' => $faker->text(),
            'type' => 2,
            'parent' => 1,
            'inscription' => 1
        ]);



        factory(Structure::class, 10)->create();
    }
}
