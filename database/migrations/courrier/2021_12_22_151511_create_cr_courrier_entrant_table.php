<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrCourrierEntrantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_courrier_entrant', function (Blueprint $table) {
            $table->id();

            $table->date('date_arrive');

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('courrier_id')->constrained('cr_courrier')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('expediteur_id')->constrained('cr_coordonnee')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('responsable_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_courrier_entrant');
    }
}
