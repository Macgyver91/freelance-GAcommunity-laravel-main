<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AbandonSeeder extends Seeder
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
            DB::table('abandons')->insert([
                'motif' => $faker->sentence(),
                "nb_rate" => mt_rand(1, 3),
                "membre_id" => mt_rand(1, 10),
                "evenement_id" => mt_rand(1, 3)

            ]);
        }
    }
}
