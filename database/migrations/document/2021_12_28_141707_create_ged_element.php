<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGedElement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ged_element', function (Blueprint $table) {
            $table->id();
            $table->boolean('actif')->default(1);
            $table->boolean('cacher')->default(0);
            $table->boolean('bloquer')->default(0);
            $table->string('password')->nullable();
            $table->string('objet_type');
            $table->unsignedBigInteger('objet_id');
            $table->dateTime('archivated_at')->nullable();
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
        Schema::dropIfExists('ged_element');
    }
}
