<?php

use App\Models\Messagerie\TypeDiscussion;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TypeDiscussionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker =  Factory::create();

        TypeDiscussion::create([
            'libelle' => 'personne-personne',
            'description' => $faker->text(),
            'inscription' => 1
        ]);


        TypeDiscussion::create([
            'libelle' => 'personne-structure',
            'description' => $faker->text(),
            'inscription' => 1
        ]);
    }
}
