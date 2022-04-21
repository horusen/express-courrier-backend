<?php

use App\Models\Messagerie\CorrespondancePersonneStructure;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class CorrespondancePersonneStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CorrespondancePersonneStructure::create([
            'user' => 1, 'structure' => 2, 'discussion' => 24, 'inscription' => 1
        ]);

        factory(CorrespondancePersonneStructure::class, 8)->create();
    }
}
