<?php

use App\Models\Messagerie\CorrespondancePersonne;
use Illuminate\Database\Seeder;

class CorrespondancePersonneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CorrespondancePersonne::class, 23)->create();
    }
}
