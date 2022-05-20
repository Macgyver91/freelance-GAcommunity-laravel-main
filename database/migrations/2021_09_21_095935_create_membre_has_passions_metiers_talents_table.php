<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembreHasPassionsMetiersTalentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membre_has_passion_metier_talents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained()->onDelete("cascade");
            $table->bigInteger('passion_metier_talent_id')->unsigned()->nullable();
            $table->foreign('passion_metier_talent_id', 'pmt_id')->references('id')->on('passion_metier_talents')->onDelete("cascade");
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
        Schema::dropIfExists('membre_has_passion_metier_talents');
    }
}
