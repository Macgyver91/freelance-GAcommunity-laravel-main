<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetitGroupeMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('petit_groupe_membres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('petit_groupe_id')->constrained()->onDelete("cascade");
            $table->foreignId('membre_id')->constrained()->onDelete("cascade");
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
        Schema::dropIfExists('petit_groupe_membres');
    }
}
