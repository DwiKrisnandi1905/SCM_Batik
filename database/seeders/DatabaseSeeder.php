<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'admin@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'harvester@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Michael Johnson', 'email' => 'factory@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Emily Davis', 'email' => 'craftsman@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'David Wilson', 'email' => 'certificator@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Olivia Taylor', 'email' => 'wastemanager@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Sophia Anderson', 'email' => 'distributor@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'name' => 'Sarah Johnson', 'email' => 'user@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],

        ]);
    
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Harvester', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Factory', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Craftsman', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Certificator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Waste Manager', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Distributor', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 4, 'user_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 5, 'user_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 6, 'user_id' => 6, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 7, 'user_id' => 7, 'created_at' => now(), 'updated_at' => now()],
        ]);

    }
}
