<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrReaffectationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_reaffectation', function (Blueprint $table) {
            $table->id();
            $table->text('libelle');
            $table->foreignId('courrier_id')->constrained('cr_courrier')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('structure_id')->constrained('structures')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('suivi_par')->nullable()->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_reaffectation');
    }
}
