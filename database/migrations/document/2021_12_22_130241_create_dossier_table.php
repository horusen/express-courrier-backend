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
            $table->boolean('actif')->default(1);
            $table->boolean('cacher')->default(0);
            $table->boolean('bloquer')->default(0);
            $table->string('password')->nullable();
            $table->foreignId('conservation')->constrained('conservation_rule')->onUpdate('restrict')->onDelete('restrict')->nullable();
            $table->foreignId('inscription')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('archivated_at');
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
