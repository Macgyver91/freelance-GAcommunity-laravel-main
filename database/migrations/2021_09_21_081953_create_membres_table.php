<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('membres', function (Blueprint $table) {
            $table->id();

            $table->enum("status", ["prospect", "membre"]);

            $table->json("info",json_encode([
                'nom',
                'prenom',
                'email',
                'genre',
                'date_naissance',
                'nationalite',
                'telephone',
                'civil_state',
                'metier',
                'talents',
                'ange',
                'origin_invi',
                'contact_perso',
                'sautQDanse',
                'musicSautQ',
                'musicVol',
                'contrat',
                'buddy',
                'photo_buddy',
                'sautQDN2',
                'sautQProjetN3',
                'chequeSQ',
                'leader_inspirant',
                'chaise_pourcentage',
                'sautQuantikReussi',
                'tribut_frere',
                'frere_t_photo',
                'animal_totem',
                'signe_astro',
                'numerologie'
            ]));
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
        Schema::dropIfExists('membres');
    }
}