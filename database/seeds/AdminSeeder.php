<?php

use App\Models\Structure\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'type' => 1,
            'user' => 1,
            'inscription' => 1
        ]);

        Admin::create([
            'type' => 2,
            'user' => 2,
            'structure' => 1,
            'inscription' => 1
        ]);

        Admin::create([
            'type' => 2,
            'user' => 3,
            'structure' => 2,
            'inscription' => 1
        ]);


        Admin::create([
            'type' => 2,
            'user' => 3,
            'structure' => 6,
            'inscription' => 1
        ]);
    }
}
