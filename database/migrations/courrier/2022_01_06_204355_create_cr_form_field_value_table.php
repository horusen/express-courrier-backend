<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrFormFieldValueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cr_form_field_value', function (Blueprint $table) {
            $table->id();
            $table->text('value');
            $table->string('objet_type');
            $table->unsignedBigInteger('objet_id');
            $table->foreignId('form_field_id')->constrained('cr_form_field')->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('cr_form_field_value');
    }
}
