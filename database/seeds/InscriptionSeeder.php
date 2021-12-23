<?php

use App\Models\Structure\Inscription;
use Illuminate\Database\Seeder;

class InscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Inscription::create([
            'prenom' => 'Babacar',
            'nom' => 'Kane',
            'identifiant' => 'identifiant-0000',
            'date_naissance' => '1997-03-16',
            'lieu_naissance' => 'Dakar',
            'telephone' => '772884035',
            'sexe' => 'HOMME'
        ]);

        factory(Inscription::class, 20)->create();
    }
}
