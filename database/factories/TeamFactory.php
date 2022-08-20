<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;

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
     * @return string[]
     *
     * @psalm-return array{name: string, content: string, summary: string, start_date: string}
     */
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company(),
            'content' => implode(' ', $this->faker->paragraphs(7)),
            'summary' => $this->faker->paragraph(),
            'start_date' => $this->faker->date()
        ];
    }
}
