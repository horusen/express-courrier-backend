<?php

use App\Models\Courrier\CrCoordonnee;
use App\Models\Courrier\CrCourrierSortant;
use App\Models\Courrier\CrDestinataire;
use App\Models\Inscription;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CrDestinataireSortantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i < 10000; $i++) {
            CrDestinataire::create([
                'inscription_id' => Inscription::all()->random()->id,
                'coordonnee_id' => CrCoordonnee::all()->random()->id,
                'courrier_id' => CrCourrierSortant::all()->random()->id,
            ]);
        }
    }
}
