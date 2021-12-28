<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('structure')->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('fichier')->constrained('fichier')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('fichier_structure');
    }
}
