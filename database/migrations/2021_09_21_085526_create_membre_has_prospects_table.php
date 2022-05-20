<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembreHasProspectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membre_has_prospects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('membre_id')->constrained()->onDelete("cascade");
            $table->foreignId('prospect_id')->constrained('membres')->onDelete("cascade");
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
        Schema::dropIfExists('membre_has_prospects');
    }
}
