<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrCoordonneeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_coordonnee', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('email')->unique();
            $table->string('telephone');
            $table->string('adresse');
            $table->text('condition_suivi')->nullable();
            $table->text('commentaire')->nullable();
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_coordonnee');
    }
}
