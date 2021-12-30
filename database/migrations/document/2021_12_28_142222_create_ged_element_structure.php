<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGedElementStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ged_element_structure', function (Blueprint $table) {
            $table->id();
            $table->foreignId('structure')->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('element')->constrained('ged_element')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('ged_element_structure');
    }
}
