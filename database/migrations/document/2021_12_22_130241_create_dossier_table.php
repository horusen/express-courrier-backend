<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDossierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dossier', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('description');
            $table->foreignId('conservation_id')->nullable()->constrained('ged_conservation_rule')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('dossier_id')->nullable()->constrained('dossier')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('dossier');
    }
}
