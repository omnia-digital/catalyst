<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class TeamLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address' => $this->faker->streetAddress(),
            'address_line_2' => '',
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postCode(),
            'country' => $this->faker->countryCode(),
        ];
    }
}
