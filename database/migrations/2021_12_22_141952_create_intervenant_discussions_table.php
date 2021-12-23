<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIntervenantDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('intervenant_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user1')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('user2')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('intervenant_discussions');
    }
}
