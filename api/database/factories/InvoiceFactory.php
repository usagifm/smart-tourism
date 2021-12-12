<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => rand(1, 10),
            'rental_id' => rand(1, 10),
            'operator_id' => rand(1, 5),
            'is_paid' => true,
            'total_charge' => rand(10_000, 50_000),
            'created_at' => $this->faker->dateTimeBetween('-12 days')
        ];
    }
}
