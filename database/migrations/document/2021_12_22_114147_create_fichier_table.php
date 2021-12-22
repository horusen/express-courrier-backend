<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type')->constrained('type_fichier')->onUpdate('restrict')->onDelete('restrict');
            $table->text('libelle');
            $table->text('fichier');
            $table->boolean('cacher')->default(0);
            $table->boolean('bloquer')->default(0);
            $table->string('password')->nullable();
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
        Schema::dropIfExists('fichier');
    }
}
