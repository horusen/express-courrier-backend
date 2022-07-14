<?php

namespace Database\Seeders\Authorization;

use App\Models\Authorization\Scope;
use Illuminate\Database\Seeder;

class ScopeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Scope::create([
            'libelle' => 'ADMIN',
            'ensemble' => 'ADMIN',
            'description' => 'une description',
        ]);

        Scope::create([
            'libelle' => 'courrier entrant',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);
        Scope::create([
            'libelle' => 'courrier sortant',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);
        Scope::create([
            'libelle' => 'coordonnees',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'proprietes courrier',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'suivis',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'dashboard',
            'ensemble' => 'courrier',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'structure',
            'ensemble' => 'GED',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'fichier',
            'ensemble' => 'GED',
            'description' => 'une description',
            'inscription' => 1
        ]);

        Scope::create([
            'libelle' => 'marche public',
            'ensemble' => 'marche public',
            'description' => 'une description',
            'inscription' => 1
        ]);


        Scope::create([
            'libelle' => 'structure',
            'ensemble' => 'structure',
            'description' => 'une description',
            'inscription' => 1
        ]);
    }
}
