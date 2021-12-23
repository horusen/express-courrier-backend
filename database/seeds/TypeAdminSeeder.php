<?php

use App\Models\Structure\TypeAdmin;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TypeAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        TypeAdmin::create([
            'libelle' => 'SUPER ADMIN',
            'description' => $faker->text,
            'inscription' => 1
        ]);


        TypeAdmin::create([
            'libelle' => 'ADMINISTRATEUR',
            'description' => $faker->text,
            'inscription' => 1
        ]);


        TypeAdmin::create([
            'libelle' => 'MODERATEUR',
            'description' => $faker->text,
            'inscription' => 1
        ]);


        TypeAdmin::create([
            'libelle' => 'SECRETAIRE GENERAL',
            'description' => $faker->text,
            'inscription' => 1
        ]);
    }
}
