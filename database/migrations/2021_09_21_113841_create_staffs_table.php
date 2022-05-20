<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->nullable()->constrained()->onDelete("cascade");
            $table->unsignedBigInteger('event_mem_id')->nullable();
            $table->unsignedBigInteger('event_gg_id')->nullable();
            $table->unsignedBigInteger('event_abandon_id')->nullable();
            $table->unsignedBigInteger('ev_abd_membre_id')->nullable();
            $table->string('nom', 45);
            $table->string('mantra', 255);
            $table->string('logo', 255);
            $table->string('type', 45);
            $table->string('photo', 255);

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
        Schema::dropIfExists('staff_lists');
    }
}
