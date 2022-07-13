<?php

namespace Database\Seeders\Authorization;

use App\Models\Authorization\Authorisation;
use Illuminate\Database\Seeder;

class AuthorisationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Authorisation::create([
            'scope' => 1,
            'role' => 1,
            'authorisation' => 'ADMIN',
        ]);


        Authorisation::create([
            'scope' => 1,
            'role' => 2,
            'authorisation' => 'ADMIN',
        ]);


        Authorisation::create([
            'scope' => 1,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 2,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 3,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 4,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 5,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 6,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 7,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 8,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);


        Authorisation::create([
            'scope' => 9,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);

        Authorisation::create([
            'scope' => 10,
            'role' => 3,
            'authorisation' => 'ECRITURE',
            'inscription' => 1
        ]);
    }
}
