<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrCourrierSortantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_courrier_sortant', function (Blueprint $table) {
            $table->id();
            $table->date('date_envoie')->nullable();
            $table->string('action_depot')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('courrier_id')->constrained('cr_courrier')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('courrier_entrant_id')->nullable()->constrained('cr_courrier_entrant')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_courrier_sortant');
    }
}
