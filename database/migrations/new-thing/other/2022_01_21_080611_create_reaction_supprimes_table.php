<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionSupprimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reaction_supprimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reaction')->constrained('reactions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('user')->nullable()->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('structure')->nullable()->constrained('structures')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('inscription')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('reaction_supprimes');
    }
}
