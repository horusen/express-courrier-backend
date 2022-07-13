<?php

use App\Models\Structure\AffectationStructure;
use Illuminate\Database\Seeder;

class AffectationStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AffectationStructure::create([
            'user' => 1,
            // 'structure' => 1,
            // 'poste' => 1,
            // 'fonction' => 1,
            'role' => 1,
            'inscription' => 1
        ]);
        AffectationStructure::create([
            'user' => 1,
            'structure' => 2,
            'poste' => 1,
            'fonction' => 1,
            'role' => 3,
            'inscription' => 1
        ]);

        factory(AffectationStructure::class, 50)->create();
    }
}
