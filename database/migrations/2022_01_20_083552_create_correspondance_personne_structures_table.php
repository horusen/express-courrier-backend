<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCorrespondancePersonneStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('correspondance_personne_structures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('user')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('structure')->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('correspondance_personne_structures');
    }
}
