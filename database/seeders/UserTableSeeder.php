<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'nom' => "Monsieur",
            'prenom' => "Super One Admin",
            'username' => "GA_community",
            "email" => "ga_community@gmail.com",
            "password" => Hash::make('GaCommunityv2'),
            "email_verified_at" => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
