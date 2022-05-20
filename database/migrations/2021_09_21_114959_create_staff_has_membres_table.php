<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffHasMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff_membres', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("staff_event_id")->nullable();
            $table->unsignedBigInteger("stf_mbr_eve_id")->nullable();
            $table->unsignedBigInteger("stf_gg_eve_id")->nullable();
            $table->unsignedBigInteger("stf_abd_eve_id")->nullable();
            $table->unsignedBigInteger("stf_abd_eve_mbr_id")->nullable();

            $table->foreignId('membre_id')->constrained()->onDelete("cascade");
            $table->foreignId('staff_list_id')->constrained("staff_lists")->onDelete("cascade");
            $table->string("commentaire", 255);
            $table->tinyInteger("taux_de_passage");
            $table->string("role_du_staff", 45);
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
        Schema::dropIfExists('staff_membres');
    }
}
