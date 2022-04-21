<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableauobjTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */ 
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('cr_tableau_objectif', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('objet');
            $table->string('couleur');
            $table->text('description');
            $table->foreignId('inscription')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_tableau_objectif');
    }
}
