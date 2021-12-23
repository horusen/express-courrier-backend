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
            $table->text('reaction');
            $table->foreignId('discussion')->constrained('discussions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('rebondissement')->nullable()->constrained('reactions')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('fichier')->nullable()->constrained('fichiers')->onUpdate('restrict')->onDelete('restrict');
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
