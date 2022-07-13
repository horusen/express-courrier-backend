<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuthorisationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('authorisations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('role')->constrained('roles')->onUpdate('restrict')->onDelete('restrict');
            $table->foreignId('scope')->constrained('scopes')->onUpdate('restrict')->onDelete('restrict');
            $table->enum('authorisation', ['ADMIN', 'LECTURE', 'ECRITURE']);
            $table->foreignId('inscription')->nullable()->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('authorisations');
    }
}
