<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepenseRecettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('depense_recettes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['D', 'R']);
            $table->string('nom', 45);
            $table->string('categorie');
            $table->integer('montant');
            $table->dateTime('date');
            $table->string('facture_devis', 255);
            $table->integer('responsable');
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
        Schema::dropIfExists('depense_recettes');
    }
}
