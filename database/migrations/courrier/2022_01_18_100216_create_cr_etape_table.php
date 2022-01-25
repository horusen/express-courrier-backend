<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrEtapeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_etape', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');//courrier, document,...
            $table->text('description')->nullable();
            $table->integer('etape');
            $table->foreignId('type_id')->constrained('cr_type')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('statut_id')->constrained('cr_statut')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('responsable_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_etape');
    }
}
