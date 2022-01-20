<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrAutorisationPersonneStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_autorisation_personne_structure', function (Blueprint $table) {
            $table->id();
            $table->boolean('envoyer_courrier')->default(0);
            $table->boolean('consulter_entrant')->default(0);
            $table->boolean('consulter_sortant')->default(0);
            $table->boolean('ajouter_personne')->default(0);
            $table->boolean('retirer_personne')->default(0);
            $table->boolean('affecter_courrier')->default(0);
            $table->boolean('consulter_messagerie')->default(0);
            $table->boolean('ecrire_messagerie')->default(0);
            $table->foreignId('structure_id')->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('personne_id')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_autorisation_personne_structure');
    }
}
