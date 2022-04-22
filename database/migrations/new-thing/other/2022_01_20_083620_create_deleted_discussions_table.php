<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeletedDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deleted_discussions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('deleted_discussions');
    }
}
