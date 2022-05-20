<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EvenementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();

        for ($i = 0; $i < 3; $i++) {
            DB::table('evenements')->insert([
                'type' => array_rand(["N1" => "N1", "N2" => "N2", "N3" => "N3", "N4" => "N4"]),
                "numero_week_end" => mt_rand(1, 2),
                "pays" => "France",
                "ville" => $faker->city(),
                "centre" => $faker->city(),

                "date_debut" => $faker->dateTimeThisYear(),
                "date_fin" => $faker->dateTimeThisYear(),
                "lieu" => $faker->city(),
                "adresse" => $faker->address(),
                "coach" => $faker->firstName(),
                "tarif" => 25.25,
                "membre_id" => mt_rand(1, 10),
                "grand_groupe_id" => mt_rand(1, 5),
                "abd_membre_id" => mt_rand(1, 5)
            ]);
        }
    }
}
