<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shop;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Shop::insert([
            [
                'shop_id' => 'central_auto_shop',
                'shop_name' => 'Central Auto Shop',
                'location_id' => 'phnom_penh',
                'address' => '123 Central St, Phnom Penh',
                'phone_number' => '012345678',
                'email' => '',
                'description' => 'Your one-stop shop for all vehicle needs in Phnom Penh.',
                'shop_image' => 'central_auto_shop.jpg',
            ],
            [
                'shop_id' => 'coastal_rides',
                'shop_name' => 'Coastal Rides',
                'location_id' => 'sihanoukville',
                'address' => '456 Beach Rd, Sihanoukville',
                'phone_number' => '098765432',
                'email' => '',
                'description' => 'Experience the best rides along the coast.',
                'shop_image' => 'coastal_rides.jpg',
            ],
            [
                'shop_id' => 'heritage_motors',
                'shop_name' => 'Heritage Motors',
                'location_id' => 'siem_reap',
                'address' => '789 Ancient Way, Siem Reap',
                'phone_number' => '011223344',
                'email' => '',
                'description' => 'Bringing you closer to the heritage sites with reliable vehicles.',
                'shop_image' => 'heritage_motors.jpg',
            ],
            [
                'shop_id' => 'kampot_cruisers',
                'shop_name' => 'Kampot Cruisers',
                'location_id' => 'kampot',
                'address' => '321 Riverside Dr, Kampot',
                'phone_number' => '022334455',
                'email' => '',
                'description' => 'Cruise through Kampot with our top-notch vehicles.',
                'shop_image' => 'kampot_cruisers.jpg',
            ],
            [
                'shop_id' => 'battambang_wheels',
                'shop_name' => 'Battambang Wheels',
                'location_id' => 'battambang',
                'address' => '654 Market St, Battambang',
                'phone_number' => '033445566',
                'email' => '',
                'description' => 'Your trusted partner for all your vehicle needs in Battambang.',
                'shop_image' => 'battambang_wheels.jpg',
            ]
        ]);            
    }
}
