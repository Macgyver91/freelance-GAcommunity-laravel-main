<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypeLienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('type_liens')->insert([
            'name' => "Frere/Soeur"
        ]);

        DB::table('type_liens')->insert([
            'name' => "Fils/Fille"
        ]);

        DB::table('type_liens')->insert([
            'name' => "Cousin(e)"
        ]);

        DB::table('type_liens')->insert([
            'name' => "Parent"
        ]);

        DB::table('type_liens')->insert([
            'name' => "Oncle/Tante"
        ]);

        DB::table('type_liens')->insert([
            'name' => "Neveu/Niece"
        ]);
    }
}
