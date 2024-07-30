<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Distributor', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Harvester', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Certificator', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Factory', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Craftsman', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
