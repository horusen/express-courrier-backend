<?php

use App\Models\Messagerie\IntervenantDiscussion;
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

        // Structure
        $this->call(InscriptionSeeder::class);
        $this->call(TypeStructureSeeder::class);
        $this->call(StructureSeeder::class);
        $this->call(TypeAdminSeeder::class);
        $this->call(FonctionSeeder::class);
        $this->call(AdminSeeder::class);
        $this->call(DroitAccesSeeder::class);
        $this->call(AffectationStructureSeeder::class);


        // Messagerie
        $this->call(TypeFichierSeeder::class);
        $this->call(ExtensionFichierSeeder::class);
        $this->call(FichierSeeder::class);
        $this->call(DiscussionSeeder::class);
        $this->call(ReactionSeeder::class);
        $this->call(IntervenantDiscussionSeeder::class);
    }
}
