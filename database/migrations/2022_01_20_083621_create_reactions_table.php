<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reactions', function (Blueprint $table) {
            $table->id();
            $table->text('reaction')->nullable()->charset('utf8mb4');
            $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('rebondissement')->nullable()->constrained('reactions')->onUpdate('restrict')->onDelete('restrict');
            $table->string('fichier')->nullable();
            $table->foreignId('inscription')->nullable()->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('reactions');
    }
}
