<?php

use App\Models\Messagerie\CorrespondancePersonneStructure;
use Illuminate\Database\Seeder;

class CorrespondancePersonneStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CorrespondancePersonneStructure::class, 2)->create();
    }
}
