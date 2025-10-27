<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\VehicleType;

class VehicleTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VehicleType::insert([
            ['vehicle_type_id' => 'motorcycle', 'vehicle_type_name' => 'Motorcycle'],
            ['vehicle_type_id' => 'bicycle', 'vehicle_type_name' => 'Bicycle'],
        ]);
    }
}