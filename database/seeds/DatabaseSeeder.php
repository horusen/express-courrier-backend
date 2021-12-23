<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(InscriptionSeeder::class);
        $this->call(TypeStructureSeeder::class);
        $this->call(StructureSeeder::class);
        $this->call(TypeAdminSeeder::class);
        $this->call(FonctionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(DroitAccesSeeder::class);
        $this->call(PosteSeeder::class);
        $this->call(AffectationStructureSeeder::class);
    }
}
