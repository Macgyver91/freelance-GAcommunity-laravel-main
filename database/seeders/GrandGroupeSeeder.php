<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrandGroupeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 5; $i++) {
            DB::table('grand_groupes')->insert([
                'type' => array_rand(["N1" => "N1", "N2" => "N2", "N3" => "N3", "N4" => "N4"]),
                "nom" => $faker->colorName(),
                "mantra" => $faker->colorName(),

                "declaration" => $faker->sentence(),
                "photo" => $faker->imageUrl(),


                "logo" => $faker->imageUrl(),
                "musique_choree" => $faker->url(),
                "video_choree" => $faker->imageUrl(),
                "photo_drapeau" => $faker->imageUrl(),

                "capitaine" => mt_rand(1, 10),
                "co_capitaine" => mt_rand(1, 10),
                "resp_com" => mt_rand(1, 10),
                "resp_heritage" => mt_rand(1, 10),
                "resp_anges" => mt_rand(1, 10),
                "resp_bateau" => mt_rand(1, 10)

            ]);
        }
    }
}
