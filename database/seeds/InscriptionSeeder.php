<?php

use App\Models\Structure\Inscription;
use Carbon\Carbon;
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
            'sexe' => 'HOMME',
            'photo' => '/images/a0.jpg',
            'email' => 'babacar@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => 'password'
        ]);

        factory(Inscription::class, 50)->create();
    }
}
