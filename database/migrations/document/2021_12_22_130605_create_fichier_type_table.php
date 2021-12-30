<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFichierTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fichier_type', function (Blueprint $table) {
            $table->id();
            $table->enum('libelle', ['archive', 'audio', 'document', 'excel', 'image', 'video', 'word', 'text', 'pdf', 'presentation'])->default('document');
            $table->string('icon');
            $table->string('extension');
            $table->foreignId('inscription_id')->constrained('inscription')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('fichier_type');
    }
}
