<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCrCourrierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('cr_courrier', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('objet');
            $table->date('date_redaction');
            $table->text('commentaire')->nullable();
            $table->boolean('valider')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreignId('nature_id')->constrained('cr_nature')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('type_id')->constrained('cr_type')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('urgence_id')->constrained('cr_urgence')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('structure_id')->constrained('structures')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('suivi_par')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('statut_id')->constrained('cr_statut')->onDelete('restrict')->onUpdate('restrict');
            $table->foreignId('inscription_id')->constrained('inscription')->onDelete('restrict')->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cr_courrier');
    }
}
