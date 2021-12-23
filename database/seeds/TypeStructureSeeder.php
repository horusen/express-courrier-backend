<?php

use App\Models\Structure\TypeStructure;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TypeStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        TypeStructure::create([
            'libelle' => 'Ministere',
            'description' => $faker->text(),
            'inscription' => 1
        ]);

        TypeStructure::create([
            'libelle' => 'Direction',
            'description' => $faker->text(),
            'inscription' => 1
        ]);


        TypeStructure::create([
            'libelle' => 'Service',
            'description' => $faker->text(),
            'inscription' => 1
        ]);
    }
}
