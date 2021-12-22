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
        factory(AffectationStructure::class, 20)->create();
    }
}
