<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrStructureCopieTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_structure_copie', function (Blueprint $table) {
            $table->id();
            $table->boolean('info')->default(1);
            $table->boolean('traitement')->default(0);
            $table->foreignId('courrier_id')->constrained('cr_courrier_entrant')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('structure_id')->constrained('structures')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_structure_copie');
    }
}
