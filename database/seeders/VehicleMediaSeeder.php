<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VehicleMedia;

class VehicleMediaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $vehicles = [
            ['vehicle_id' => 'veh_001', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Giant Escape 3'],
            ['vehicle_id' => 'veh_002', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Trek FX 1'],
            ['vehicle_id' => 'veh_003', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Honda CB125R'],
            ['vehicle_id' => 'veh_004', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Yamaha XSR155'],
            ['vehicle_id' => 'veh_005', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Specialized Sirrus 2.0'],
            ['vehicle_id' => 'veh_006', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Cannondale Quick 4'],
            ['vehicle_id' => 'veh_007', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Honda CB500X'],
            ['vehicle_id' => 'veh_008', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Suzuki Raider R150'],
            ['vehicle_id' => 'veh_009', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Trek Domane AL 2'],
            ['vehicle_id' => 'veh_010', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Giant Contend 3'],
            ['vehicle_id' => 'veh_011', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Yamaha MT-15'],
            ['vehicle_id' => 'veh_012', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Honda Rebel 300'],
            ['vehicle_id' => 'veh_013', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Merida Crossway 100'],
            ['vehicle_id' => 'veh_014', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Polygon Heist 3'],
            ['vehicle_id' => 'veh_015', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Yamaha Aerox 155'],
            ['vehicle_id' => 'veh_016', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Honda PCX 160'],
            ['vehicle_id' => 'veh_017', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Cube Nature Pro'],
            ['vehicle_id' => 'veh_018', 'vehicle_type' => 'bicycle', 'vehicle_name' => 'Scott Sub Cross 50'],
            ['vehicle_id' => 'veh_019', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Honda Click 150i'],
            ['vehicle_id' => 'veh_020', 'vehicle_type' => 'motorcycle', 'vehicle_name' => 'Yamaha Mio 125'],
        ];

        $mediaData = [];

        foreach ($vehicles as $v) {
            // Replace spaces with + instead of %20
            $fileName = str_replace(' ', '+', $v['vehicle_name']);
            $mediaData[] = [
                'vehicle_id' => $v['vehicle_id'],
                'media_type' => 'image',
                'media_url' => "/vehicles/{$v['vehicle_type']}/{$fileName}.png",
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        VehicleMedia::insert($mediaData);
    }
}
