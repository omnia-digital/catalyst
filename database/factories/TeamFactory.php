<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Team::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'user_id' => User::inRandomOrder()->first()->id,
            'personal_team' => false,
            'content' => implode(' ', $this->faker->paragraphs(7)),
            'summary' => $this->faker->paragraph(),
            'start_date' => $this->faker->date()
        ];
    }
}
