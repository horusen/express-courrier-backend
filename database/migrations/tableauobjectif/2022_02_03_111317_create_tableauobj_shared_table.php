<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableauobjSharedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_tableau_objectif_shared', function (Blueprint $table) {
            $table->id();
            $table->foreignId('objectif')->constrained('cr_tableau_objectif')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('receveur')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('inscription')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_tableau_objectif_shared');
    }
}
