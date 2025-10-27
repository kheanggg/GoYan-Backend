<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Location;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Location::insert([
            ['location_id' => 'phnom_penh', 'location_name' => 'Phnom Penh'],
            ['location_id' => 'siem_reap', 'location_name' => 'Siem Reap'],
            ['location_id' => 'sihanoukville', 'location_name' => 'Sihanoukville'],
            ['location_id' => 'kampot', 'location_name' => 'Kampot'],
            ['location_id' => 'battambang', 'location_name' => 'Battambang'],
        ]);
    }
}
