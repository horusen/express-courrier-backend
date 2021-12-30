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
            'structure' => 1,
            'poste' => 1,
            'fonction' => 1,
            'is_responsable' => 1,
            'droit_acces' => 1,
            'inscription' => 1
        ]);

        factory(AffectationStructure::class, 50)->create();
    }
}
