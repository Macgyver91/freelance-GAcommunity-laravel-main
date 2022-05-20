<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MembreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('membres')->insert([
                'status' => array_rand(["prospect" => "prospect", "membre" => "membre"]),
                'info' => json_encode([
                    'nom' => $faker->firstName(),
                    "prenom" => $faker->lastName(),
                    "email" => $faker->safeEmail(),
                    "genre" => array_rand(["homme" => "homme", "femme" => "femme", "autre" => "autre"]),
                    "date_naissance" => $faker->date(),
                    "nationalite" => $faker->country(),
                    "telephone" => $faker->phoneNumber(),
                    'civil_state'=>$faker->lastName(),
                    'metier'=>$faker->sentence(),
                    'talents'=>$faker->sentence(),
                    'ange'=>$faker->sentence(),
                    'origin_invi'=>$faker->sentence(),
                    'contact_perso'=>$faker->sentence(),
                    'sautQDanse'=>$faker->sentence(),
                    'musicSautQ'=>$faker->sentence(),
                    'musicVol'=>$faker->sentence(),
                    'contrat'=>$faker->sentence(),
                    'buddy'=>$faker->firstName(),
                    'photo_buddy'=> $faker->imageUrl(),
                    'sautQDN2'=>$faker->sentence(),
                    'sautQProjetN3'=>$faker->sentence(),
                    'chequeSQ'=>$faker->sentence(),
                    'leader_inspirant'=>$faker->lastName(),
                    'chaise_pourcentage'=>$faker->randomDigit(),
                    'sautQuantikReussi'=>$faker->sentence(),
                    'tribut_frere'=> $faker->lastName(),
                    'frere_t_photo'=> $faker->imageUrl(),
                    'animal_totem'=>$faker->lastName(),
                    'signe_astro'=>$faker->lastName(),
                    'numerologie'=>$faker->randomDigit()
                ])
            ]);
        }
    }
}