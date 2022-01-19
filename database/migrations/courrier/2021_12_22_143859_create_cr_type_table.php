<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_type', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');//courrier, document,...
            $table->text('description');
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('type_id')->nullable()->constrained('cr_type')->onDelete('restrict')->onUpdate('restrict');
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
        Schema::dropIfExists('cr_type');
    }
}
