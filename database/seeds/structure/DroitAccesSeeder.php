<?php

use App\Models\Structure\DroitAcces;
use Illuminate\Database\Seeder;

class DroitAccesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(DroitAcces::class, 4)->create();
    }
}
