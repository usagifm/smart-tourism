<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OperatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email,
            'role' => 'op',
            'password' => bcrypt('password')
        ];
    }
}
