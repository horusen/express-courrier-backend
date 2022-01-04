<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrAmpiliationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_ampiliation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courrier_id')->constrained('cr_courrier_sortant')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('coordonnee_id')->constrained('cr_coordonnee')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_ampiliation');
    }
}
