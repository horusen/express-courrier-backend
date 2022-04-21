<?php

use App\Models\Courrier\CrCoordonnee;
use App\Models\Inscription;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CrCoordonneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i=0; $i < 10000; $i++) {
            CrCoordonnee::create([
                'libelle' => $faker->unique()->company(),
                'email' => $faker->unique()->email(),
                'telephone' => $faker->phoneNumber(),
                'adresse' => $faker->address(),
                'condition_suivi' => $faker->text(),
                'commentaire' => $faker->text(),
                'inscription_id' => Inscription::all()->random()->id,
            ]);
        }
    }
}
