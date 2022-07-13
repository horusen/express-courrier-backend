<?php

namespace Database\Seeders\Authorization;

use App\Models\Authorization\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'libelle' => 'SUPER ADMIN',
            'description' => 'une description'
        ]);

        Role::create([
            'libelle' => 'ADMIN',
            'description' => 'une description'
        ]);

        Role::create([
            'libelle' => 'Défaut',
            'description' => 'une description'
        ]);
    }
}
