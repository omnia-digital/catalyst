<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return string[]
     *
     * @psalm-return array{name: string, icon: 'heroicon-o-academic-cap'}
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word() . ' Award',
            'icon' => 'heroicon-o-academic-cap',
        ];
    }
}
