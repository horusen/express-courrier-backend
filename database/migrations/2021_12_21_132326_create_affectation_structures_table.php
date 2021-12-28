<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffectationStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affectation_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('structure')->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('fonction')->constrained('fonctions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('poste')->constrained('postes')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('droit_acces')->constrained('droit_acces')->onUpdate('restrict')->onDelete('restrict');
            $table->boolean('is_responsable');
            $table->foreignId('inscription')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('affectation_structures');
    }
}
