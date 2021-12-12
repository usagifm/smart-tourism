<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_type_id' => rand(1, 2),
            'label' => $this->faker->company,
            'serial_number' => Str::random(10),
            'fare' => rand(1_000, 50_000),
            'is_available' => true,
            'description' => $this->faker->words(4, true),
            'is_inside' => '1',
            'rent_area_id' => rand(1, 2),
            'brand' => $this->faker->company
        ];
    }
}
