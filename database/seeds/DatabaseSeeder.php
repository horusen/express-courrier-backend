<?php

use Authorization\ScopeSeeder;
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
        // $this->call(InscriptionSeeder::class);
        // $this->call(TypeStructureSeeder::class);
        // $this->call(StructureSeeder::class);
        // $this->call(TypeAdminSeeder::class);
        // $this->call(FonctionSeeder::class);
        // $this->call(AdminSeeder::class);
        // $this->call(DroitAccesSeeder::class);
        // $this->call(PosteSeeder::class);
        // $this->call(AffectationStructureSeeder::class);
        // $this->call(ResponsableStructureSeeder::class);
        // $this->call(AutorisationPersonneStructureSeeder::class);
        // $this->call(ConditionsUtilisationSeeder::class);

        // $this->call(FichierTypeSeeder::class);
        // $this->call(CrStatutSeeder::class);


        // Messagerie
        // $this->call(TypeFichierSeeder::class);
        // $this->call(ExtensionFichierSeeder::class);
        // $this->call(FichierSeeder::class);

        // $this->call(TypeDiscussionSeeder::class);
        // $this->call(DiscussionSeeder::class);
        // $this->call(CorrespondancePersonneSeeder::class);
        // $this->call(CorrespondancePersonneStructureSeeder::class);
        // $this->call(ReactionSeeder::class);
        // $this->call(ReactionStructureSeeder::class);

        $this->call(ScopeSeeder::class);
        $this->call(RoleSeeder::class);

        // $this->call(IntervenantDiscussionSeeder::class);
        // $this->call(ReactionSeeder::class);

        // Courrier
        // $this->call(CrCoordonneeSeeder::class);
        // $this->call(CrCourrierEntrantSeeder::class);
        // $this->call(CrCourrierSortantSeeder::class);
        // $this->call(CrDestinataireSortantSeeder::class);
    }
}
