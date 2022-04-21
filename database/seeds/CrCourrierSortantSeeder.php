<?php

use App\Models\Courrier\CrCourrier;
use App\Models\Courrier\CrCourrierEntrant;
use App\Models\Courrier\CrCourrierSortant;
use App\Models\Courrier\CrNature;
use App\Models\Courrier\CrStatut;
use App\Models\Courrier\CrType;
use App\Models\Courrier\CrUrgence;
use App\Models\Inscription;
use App\Models\Structure;
use Faker\Factory;
use Illuminate\Database\Seeder;

class CrCourrierSortantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=0; $i < 645; $i++) {
            $item = CrCourrier::create([
                'inscription_id' => Inscription::all()->random()->id,
                'libelle' => $this->generateUniqueToken(),
                'objet' => $faker->realText(190),
                'date_redaction' => $faker->dateTime(),
                'commentaire' => $faker->realText(),
                'valider' => $faker->numberBetween(0,1),
                'type_id' => CrType::all()->random()->id,
                'urgence_id' => CrUrgence::all()->random()->id,
                'statut_id' => CrStatut::all()->random()->id,
                'nature_id' => CrNature::all()->random()->id,
                'structure_id' => Structure::all()->random()->id,
                'suivi_par' => Inscription::all()->random()->id,
            ]);

            CrCourrierSortant::create([
                'inscription_id' => Inscription::all()->random()->id,
                'date_envoie' => $faker->dateTime(),
                'courrier_id' => $item->id,
                'courrier_entrant_id' => CrCourrierEntrant::all()->random()->id,
            ]);
        }
    }

    public function getToken($length, $prefix){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "0123456789";

        mt_srand();

        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }

        $token = $prefix. $token . substr(strftime("%Y", time()),2);
        return $token;
    }

    public function generateUniqueToken()
    {
        do {
           $code = $this->getToken(6, 'CS');
        } while (CrCourrier::where("libelle", "=", $code)->first());

        return $code;
    }
}
