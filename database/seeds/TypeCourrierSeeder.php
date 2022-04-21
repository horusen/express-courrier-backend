<?php

use App\Models\Courrier\CrType;
use Illuminate\Database\Seeder;

class TypeCourrierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CrType::class, 5)->create();
    }
}
