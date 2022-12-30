<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Player>
 */
class PlayerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name'  => $this->faker->lastName(),
            'gender'     => $this->faker->randomElement(['Male', 'Female']),
            'strength'   => $this->faker->numberBetween(1, 100),
            'speed'      => $this->faker->numberBetween(1, 100),
            'reaction'   => $this->faker->numberBetween(1, 100),
        ];
    }
}
