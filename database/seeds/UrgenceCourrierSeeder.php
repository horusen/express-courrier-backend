<?php

use App\Models\Courrier\CrUrgence;
use Illuminate\Database\Seeder;

class UrgenceCourrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CrUrgence::class, 5);
    }
}
