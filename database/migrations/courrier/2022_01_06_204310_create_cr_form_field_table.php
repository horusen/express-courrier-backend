<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrFormFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_form_field', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('label');
            $table->string('value');
            $table->string('type');
            $table->boolean('required');
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
        Schema::dropIfExists('cr_form_field');
    }
}
