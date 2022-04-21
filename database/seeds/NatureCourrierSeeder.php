<?php

use App\Models\Courrier\CrNature;
use Illuminate\Database\Seeder;

class NatureCourrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CrNature::create([
            'libelle' => 'courrier',
            'description' => 'Une description',
            'inscription' => 1
        ]);


        CrNature::create([
            'libelle' => 'document',
            'description' => 'Une description',
            'inscription' => 1
        ]);
    }
}
