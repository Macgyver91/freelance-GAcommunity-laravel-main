<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEvenementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['N1', 'N2', 'N3', 'N4']);
            $table->integer('numero_week_end');
            $table->enum('pays', ["France"]);
            $table->string("ville", 45);
            $table->string("centre", 45);
            $table->dateTime("date_debut");
            $table->dateTime("date_fin");
            $table->string("lieu", 45);
            $table->string("adresse", 255);
            $table->string("coach", 45);
            $table->decimal("tarif", 15, 2);
            $table->foreignId('membre_id')->constrained()->onDelete("cascade");
            $table->foreignId('grand_groupe_id')->constrained()->onDelete("cascade");
            $table->unsignedBigInteger('abd_membre_id')->nullable();
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
        Schema::dropIfExists('evenements');
    }
}
