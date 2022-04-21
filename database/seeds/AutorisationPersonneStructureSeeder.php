<?php

use App\Models\Courrier\CrAutorisationPersonneStructure;
use Illuminate\Database\Seeder;

class AutorisationPersonneStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'consulter_messagerie' => true,
            'ecrire_messagerie' => true,
            'structure_id' => 1,
            'personne_id' => 1,
            'inscription_id' => 1
        ]);

        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'consulter_messagerie' => true,
            'ecrire_messagerie' => true,
            'structure_id' => 1,
            'personne_id' => 2,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'structure_id' => 2,
            'personne_id' => 2,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'structure_id' => 2,
            'personne_id' => 4,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'structure_id' => 3,
            'personne_id' => 2,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'structure_id' => 4,
            'personne_id' => 7,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'structure_id' => 5,
            'personne_id' => 8,
            'inscription_id' => 1
        ]);


        CrAutorisationPersonneStructure::create([
            'envoyer_courrier' => true,
            'consulter_entrant' => true,
            'consulter_sortant' => true,
            'ajouter_personne' => true,
            'retirer_personne' => true,
            'affecter_courrier' => true,
            'ecrire_messagerie' => true,
            'consulter_messagerie' => true,
            'structure_id' => 6,
            'personne_id' => 9,
            'inscription_id' => 1
        ]);

        for ($i = 7; $i <= 25; $i++) {
            CrAutorisationPersonneStructure::create([
                'envoyer_courrier' => true,
                'consulter_entrant' => true,
                'consulter_sortant' => true,
                'ajouter_personne' => true,
                'retirer_personne' => true,
                'affecter_courrier' => true,
                'ecrire_messagerie' => true,
                'consulter_messagerie' => true,
                'structure_id' => $i,
                'personne_id' => $i + 3,
                'inscription_id' => 1
            ]);
        }
    }
}
