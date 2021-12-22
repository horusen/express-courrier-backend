<?php

use App\Models\Structure\Fonction;
use Illuminate\Database\Seeder;

class FonctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Fonction::class, 7)->create();
    }
}
