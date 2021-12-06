<?php

namespace Database\Seeders;

use App\Models\RentArea;
use App\Models\User;
use App\Models\VehicleType;
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
        // \App\Models\User::factory(10)->create();
        User::create([
            'name' => 'a',
            'email' => 'a@a',
            'password' => bcrypt('1'),
            'nik' => '11',
            'phone' => '11'
        ]);

        $vehicleTypes = [
            [
                'type' => 'Sepeda Kayuh',
                'description' => 'Sepeda kayuh yang harganya sedang'
            ],
            [
                'type' => 'ATV',
                'description' => 'ATV yang harganya mahal sekali'
            ]
        ];

        foreach ($vehicleTypes as $vehicleType) {
            VehicleType::create($vehicleType);
        }

        $rentAreas = [
            [
                'name' => 'Islamic Center Mantap',
                'operational_hour' => '',
                'origin' => 'ChIJcdsEK6zEQC4RSUoTGNyoLRE',
                'destination' => 'ChIJu9xDDV3FQC4RUyVsXFijGR8',
                'tolerance' => 300
            ],
            [
                'name' => 'Perumahan Walikota Tubaba',
                'operational_hour' => '',
                'origin' => 'ChIJcdsEK6zEQC4RSUoTGNyoLRE',
                'destination' => 'ChIJu9xDDV3FQC4RUyVsXFijGR8',
                'tolerance' => 300
            ],
        ];

        foreach ($rentAreas as $rentArea) {
            RentArea::create($rentArea);
        }
    }
}
