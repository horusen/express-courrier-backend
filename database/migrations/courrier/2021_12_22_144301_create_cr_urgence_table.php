<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrUrgenceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_urgence', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('couleur');
            $table->string('description');
            $table->Integer('delai');
            $table->Integer('delai_relance1');
            $table->Integer('delai_relance2');
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
        Schema::dropIfExists('cr_urgence');
    }
}
