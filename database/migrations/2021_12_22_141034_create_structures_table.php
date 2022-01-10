<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStructuresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('structures', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('cigle');
            $table->string('image')->nullable();
            $table->text('description');
            $table->foreignId('type')->constrained('type_structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('inscription')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->nestedSet();
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
        Schema::table('structures', function (Blueprint $table) {
            $table->dropNestedSet();
        });
        Schema::dropIfExists('structures');
    }
}
