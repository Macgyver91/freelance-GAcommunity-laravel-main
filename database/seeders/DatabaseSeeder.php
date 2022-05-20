<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            MembreSeeder::class,
            RoleUserSeeder::class,
            GrandGroupeSeeder::class,
            PetitGroupeSeeder::class,
            EvenementSeeder::class,
            AbandonSeeder::class,
            TypeLienSeeder::class
        ]);
    }
}
