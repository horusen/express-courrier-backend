<?php

use App\Models\Courrier\CrMail;
use Illuminate\Database\Seeder;

class CrMailSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CrMail::class, 5000)->create();
    }
}
