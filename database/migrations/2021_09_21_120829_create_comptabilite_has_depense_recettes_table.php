<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComptabiliteHasDepenseRecettesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comptabilite_has_depense_recettes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comptabilite_id')->constrained()->onDelete("cascade");
            $table->foreignId('depense_recette_id')->constrained()->onDelete("cascade");
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
        Schema::dropIfExists('comptabilite_has_depense_recettes');
    }
}
