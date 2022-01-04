<?php

use App\Models\Structure\ResponsableStructure;
use Illuminate\Database\Seeder;

class ResponsableStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i < 7; $i++) {
            ResponsableStructure::create([
                'structure' => $i,
                'responsable' => $i,
                'inscription' => 1
            ]);
        }
    }
}
