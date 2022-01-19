<?php

use App\Models\Courrier\CrStatut;
use Illuminate\Database\Seeder;

class CrStatutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CrStatut::create([
            'libelle' => 'traiter',
            'inscription_id' => 1
        ]);

        CrStatut::create([
            'libelle' => 'non traiter',
            'inscription_id' => 1
        ]);

        CrStatut::create([
            'libelle' => 'en traitement',
            'inscription_id' => 1
        ]);
    }
}
