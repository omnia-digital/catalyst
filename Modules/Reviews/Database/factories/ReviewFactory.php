<?php

namespace Modules\Reviews\Database\factories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Reviews\Models\Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $team = Team::all()->random()->load('users');

        return [
            'user_id' => $team->users->random()->id,
            'reviewable_id' => $team->id,
            'reviewable_type' => $team::class,
            'body' => $this->faker->paragraph(4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
