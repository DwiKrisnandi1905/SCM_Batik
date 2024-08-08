<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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

        DB::table('harvests')->insert([
            [
                'user_id' => 1,
                'material_type' => 'Wheat',
                'quantity' => 100.5,
                'quality' => 'High',
                'delivery_info' => 'Delivered by truck',
                'delivery_date' => Carbon::now()->addDays(5),
                'image' => 'wheat.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'material_type' => 'Corn',
                'quantity' => 200.0,
                'quality' => 'Medium',
                'delivery_info' => 'Delivered by train',
                'delivery_date' => Carbon::now()->addDays(7),
                'image' => 'corn.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'material_type' => 'Rice',
                'quantity' => 150.75,
                'quality' => 'Low',
                'delivery_info' => 'Delivered by ship',
                'delivery_date' => Carbon::now()->addDays(10),
                'image' => 'rice.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('factories')->insert([
            [
                'user_id' => 1, // Make sure this user ID exists in the users table
                'harvest_id' => 1, // Make sure this harvest ID exists in the harvests table
                'received_date' => Carbon::now()->addDays(2),
                'initial_process' => 'Drying',
                'semi_finished_quantity' => 80.0,
                'semi_finished_quality' => 'High',
                'factory_name' => 'Green Valley Processing Plant',
                'factory_address' => '123 Valley Road, Springfield',
                'image' => 'factory1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'harvest_id' => 2,
                'received_date' => Carbon::now()->addDays(3),
                'initial_process' => 'Milling',
                'semi_finished_quantity' => 180.5,
                'semi_finished_quality' => 'Medium',
                'factory_name' => 'Riverbend Mill',
                'factory_address' => '456 River Road, River City',
                'image' => 'factory2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'harvest_id' => 3,
                'received_date' => Carbon::now()->addDays(4),
                'initial_process' => 'Fermentation',
                'semi_finished_quantity' => 120.75,
                'semi_finished_quality' => 'Low',
                'factory_name' => 'Sunrise Brewery',
                'factory_address' => '789 Brewery Lane, Sun City',
                'image' => 'factory3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('craftsmen')->insert([
            [
                'user_id' => 1,
                'factory_id' => 1,
                'production_details' => 'Handcrafted wooden chairs',
                'finished_quantity' => 50.0,
                'completion_date' => Carbon::now()->addDays(7),
                'image' => 'chairs.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'factory_id' => 2,
                'production_details' => 'Hand-sewn leather bags',
                'finished_quantity' => 30.5,
                'completion_date' => Carbon::now()->addDays(10),
                'image' => 'bags.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'factory_id' => 3,
                'production_details' => 'Hand-painted ceramic vases',
                'finished_quantity' => 20.75,
                'completion_date' => Carbon::now()->addDays(12),
                'image' => 'vases.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('waste_management')->insert([
            [
                'user_id' => 1,
                'craftsman_id' => 1,
                'waste_type' => 'Wood Scraps',
                'management_method' => 'Recycling',
                'management_results' => 'Wood chips for particleboard',
                'image' => 'wood_chips.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'craftsman_id' => 2,
                'waste_type' => 'Leather Scraps',
                'management_method' => 'Reuse',
                'management_results' => 'Leather patches for small goods',
                'image' => 'leather_patches.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'craftsman_id' => 3,
                'waste_type' => 'Ceramic Shards',
                'management_method' => 'Safe Disposal',
                'management_results' => 'Shards safely disposed',
                'image' => 'ceramic_disposal.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);


        DB::table('certifications')->insert([
            [
                'user_id' => 1,
                'craftsman_id' => 1,
                'test_results' => 'Passed with Distinction',
                'certificate_number' => 'CERT12345',
                'issue_date' => Carbon::now()->subMonths(3),
                'image' => 'certification1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'craftsman_id' => 2,
                'test_results' => 'Passed',
                'certificate_number' => 'CERT67890',
                'issue_date' => Carbon::now()->subMonths(6),
                'image' => 'certification2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'craftsman_id' => 3,
                'test_results' => 'Passed with Honors',
                'certificate_number' => 'CERT11223',
                'issue_date' => Carbon::now()->subMonths(1),
                'image' => 'certification3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('distributions')->insert([
            [
                'user_id' => 1, 
                'craftsman_id' => 1, 
                'destination' => '123 Elm Street, Springfield',
                'quantity' => 150.0,
                'shipment_date' => Carbon::now()->subDays(10),
                'tracking_number' => 'TRACK123456789',
                'received_date' => Carbon::now()->subDays(5),
                'receiver_name' => 'John Doe',
                'received_condition' => 'Good',
                'image' => 'distribution1.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 2,
                'craftsman_id' => 2,
                'destination' => '456 Oak Avenue, Rivertown',
                'quantity' => 200.5,
                'shipment_date' => Carbon::now()->subDays(15),
                'tracking_number' => 'TRACK987654321',
                'received_date' => Carbon::now()->subDays(7),
                'receiver_name' => 'Jane Smith',
                'received_condition' => 'Fair',
                'image' => 'distribution2.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'user_id' => 3,
                'craftsman_id' => 3,
                'destination' => '789 Pine Road, Greenfield',
                'quantity' => 75.25,
                'shipment_date' => Carbon::now()->subDays(5),
                'tracking_number' => 'TRACK564738291',
                'received_date' => Carbon::now()->subDays(2),
                'receiver_name' => 'Emily Johnson',
                'received_condition' => 'Excellent',
                'image' => 'distribution3.jpg',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
