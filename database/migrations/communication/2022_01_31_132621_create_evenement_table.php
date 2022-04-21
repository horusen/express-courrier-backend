<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('cr_evenement', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('objet');
            $table->string('lieu');
            $table->string('type');
            $table->date('date');
            $table->time('heure_debut');
            $table->time('heure_fin');
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
        Schema::dropIfExists('cr_evenement');
    }
}
