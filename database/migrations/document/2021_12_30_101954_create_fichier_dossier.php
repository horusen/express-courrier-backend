<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierDossier extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier_dossier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fichier_id')->constrained('fichier')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('dossier_id')->constrained('dossier')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fichier_dossier');
    }
}
