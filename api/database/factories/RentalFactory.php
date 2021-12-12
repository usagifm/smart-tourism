<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class RentalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vehicle_id' => rand(1, 5),
            'user_id' => rand(1, 10),
            'status' => 'paid'
        ];
    }
}
