<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrandGroupesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grand_groupes', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['N1', 'N2', 'N3', 'N4']);
            $table->string('nom', 45);
            $table->string('mantra', 255);
            $table->string('declaration', 255);
            $table->string('photo', 255);
            $table->string('logo', 255);
            $table->string('musique_choree', 255);
            $table->string('video_choree', 255);
            $table->string('photo_drapeau', 255);

            $table->unsignedBigInteger('capitaine')->nullable();
            $table->unsignedBigInteger('co_capitaine')->nullable();
            $table->unsignedBigInteger('resp_com')->nullable();
            $table->unsignedBigInteger('resp_heritage')->nullable();
            $table->unsignedBigInteger('resp_anges')->nullable();
            $table->unsignedBigInteger('resp_bateau')->nullable();

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
        Schema::dropIfExists('grand_groupes');
    }
}
