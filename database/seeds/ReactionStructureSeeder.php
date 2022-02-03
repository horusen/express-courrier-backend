<?php

use App\Models\Messagerie\Reaction;
use App\Models\Messagerie\ReactionStructure;
use Illuminate\Database\Seeder;

class ReactionStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reactions = Reaction::has('discussion.correspondance_personne_structure')->get();

        foreach ($reactions as $reaction) {
            if ($reaction->discussion()->get()->first()->correspondance_personne_structure->structure()->get()->first()->charge_ecriture_messageries[0]->id == $reaction->inscription) {
                ReactionStructure::create([
                    'reaction' => $reaction->id,
                    'structure' => $reaction->discussion()->get()->first()->correspondance_personne_structure->structure,
                    'inscription' => $reaction->inscription
                ]);
            }
        }
    }
}
