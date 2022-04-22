<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateCourrierDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('courrier_discussions', function (Blueprint $table) {
        //     $table->id();
        //     $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
        //     $table->foreignId('courrier')->constrained('cr_courrier')->onUpdate('restrict')->onDelete('restrict');
        //     $table->foreignId('inscription')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courrier_discussions');
    }
}
