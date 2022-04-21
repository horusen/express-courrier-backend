<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilevenementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_file_evenement', function (Blueprint $table) {
            $table->id();
            $table->string('fichier');
            $table->string('nom_fichier');
            $table->foreignId('evenement')->constrained('cr_evenement')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_file_evenement');
    }
}
