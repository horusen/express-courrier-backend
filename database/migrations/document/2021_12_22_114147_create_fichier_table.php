<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('fichier', function (Blueprint $table) {
            $table->id();
            $table->foreignId('type_id')->constrained('fichier_type')->onUpdate('restrict')->onDelete('restrict');
            $table->text('libelle');
            $table->text('fichier');
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
        Schema::dropIfExists('fichier');
    }
}
