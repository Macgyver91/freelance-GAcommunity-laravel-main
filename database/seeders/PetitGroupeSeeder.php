<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PetitGroupeSeeder extends Seeder
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
            DB::table('petit_groupes')->insert([
                'capitaine' => mt_rand(1, 10),
                "photo" => $faker->imageUrl(),
                "grand_groupe_id" => mt_rand(1, 5),
            ]);
        }
    }
}
