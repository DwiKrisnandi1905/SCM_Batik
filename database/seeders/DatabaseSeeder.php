<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::table('users')->insert([
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Michael Johnson', 'email' => 'michael@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Emily Davis', 'email' => 'emily@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'David Wilson', 'email' => 'david@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Olivia Taylor', 'email' => 'olivia@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'name' => 'Sophia Anderson', 'email' => 'sophia@example.com', 'password' => bcrypt('password'), 'created_at' => now(), 'updated_at' => now()],

        ]);
        DB::table('roles')->insert([
            ['id' => 1, 'name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Distributor', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Harvester', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Certificator', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Factory', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Craftsman', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('role_user')->insert([
            ['role_id' => 1, 'user_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 2, 'user_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 3, 'user_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 4, 'user_id' => 4, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 5, 'user_id' => 5, 'created_at' => now(), 'updated_at' => now()],
            ['role_id' => 6, 'user_id' => 6, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('factories')->insert([
            ['id' => 1, 'name' => 'Factory 1', 'location' => 'Location 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Factory 2', 'location' => 'Location 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Factory 3', 'location' => 'Location 3', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Factory 4', 'location' => 'Location 4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'name' => 'Factory 5', 'location' => 'Location 5', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'name' => 'Factory 6', 'location' => 'Location 6', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('craftsmen')->insert([
            ['id' => 1, 'user_id' => 6, 'factory_id' => 1, 'production_details' => 'Production Details 1', 'finished_quantity' => 100, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 6, 'factory_id' => 2, 'production_details' => 'Production Details 2', 'finished_quantity' => 200, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => 6, 'factory_id' => 3, 'production_details' => 'Production Details 3', 'finished_quantity' => 300, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'user_id' => 6, 'factory_id' => 4, 'production_details' => 'Production Details 4', 'finished_quantity' => 400, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'user_id' => 6, 'factory_id' => 5, 'production_details' => 'Production Details 5', 'finished_quantity' => 500, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'user_id' => 6, 'factory_id' => 6, 'production_details' => 'Production Details 6', 'finished_quantity' => 600, 'completion_date' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('certifications')->insert([
            ['id' => 1, 'user_id' => 4, 'craftsman_id' => 1, 'test_results' => 'Test Results 1', 'certificate_number' => 'Certificate Number 1', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 4, 'craftsman_id' => 2, 'test_results' => 'Test Results 2', 'certificate_number' => 'Certificate Number 2', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => 4, 'craftsman_id' => 3, 'test_results' => 'Test Results 3', 'certificate_number' => 'Certificate Number 3', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'user_id' => 4, 'craftsman_id' => 4, 'test_results' => 'Test Results 4', 'certificate_number' => 'Certificate Number 4', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'user_id' => 4, 'craftsman_id' => 5, 'test_results' => 'Test Results 5', 'certificate_number' => 'Certificate Number 5', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'user_id' => 4, 'craftsman_id' => 6, 'test_results' => 'Test Results 6', 'certificate_number' => 'Certificate Number 6', 'issue_date' => now(), 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('harvests')->insert([
            ['id' => 1, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 1', 'harvest_quantity' => 100, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 2', 'harvest_quantity' => 200, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 3', 'harvest_quantity' => 300, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 4', 'harvest_quantity' => 400, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 5', 'harvest_quantity' => 500, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'user_id' => 3, 'harvest_date' => now(), 'harvest_location' => 'Harvest Location 6', 'harvest_quantity' => 600, 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('distributors')->insert([
            ['id' => 1, 'user_id' => 2, 'harvest_id' => 1, 'received_date' => now(), 'initial_process' => 'Initial Process 1', 'semi_finished_quantity' => 100, 'semi_finished_quality' => 'Semi Finished Quality 1', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'user_id' => 2, 'harvest_id' => 2, 'received_date' => now(), 'initial_process' => 'Initial Process 2', 'semi_finished_quantity' => 200, 'semi_finished_quality' => 'Semi Finished Quality 2', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'user_id' => 2, 'harvest_id' => 3, 'received_date' => now(), 'initial_process' => 'Initial Process 3', 'semi_finished_quantity' => 300, 'semi_finished_quality' => 'Semi Finished Quality 3', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'user_id' => 2, 'harvest_id' => 4, 'received_date' => now(), 'initial_process' => 'Initial Process 4', 'semi_finished_quantity' => 400, 'semi_finished_quality' => 'Semi Finished Quality 4', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'user_id' => 2, 'harvest_id' => 5, 'received_date' => now(), 'initial_process' => 'Initial Process 5', 'semi_finished_quantity' => 500, 'semi_finished_quality' => 'Semi Finished Quality 5', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'user_id' => 2, 'harvest_id' => 6, 'received_date' => now(), 'initial_process' => 'Initial Process 6', 'semi_finished_quantity' => 600, 'semi_finished_quality' => 'Semi Finished Quality 6', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('monitorings')->insert([
            ['id' => 1, 'distributor_id' => 1, 'craftsman_id' => 1, 'harvest_id' => 1, 'factory_id' => 1, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'distributor_id' => 2, 'craftsman_id' => 2, 'harvest_id' => 2, 'factory_id' => 2, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'distributor_id' => 3, 'craftsman_id' => 3, 'harvest_id' => 3, 'factory_id' => 3, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'distributor_id' => 4, 'craftsman_id' => 4, 'harvest_id' => 4, 'factory_id' => 4, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5, 'distributor_id' => 5, 'craftsman_id' => 5, 'harvest_id' => 5, 'factory_id' => 5, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'distributor_id' => 6, 'craftsman_id' => 6, 'harvest_id' => 6, 'factory_id' => 6, 'status' => 'Pending', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
