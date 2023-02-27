<?php

namespace Database\Factories;

use Modules\Livestream\Models\Episode;
use Illuminate\Database\Eloquent\Factories\Factory;

class EpisodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Episode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title'                 => $this->faker->name,
            'description'           => $this->faker->paragraph,
            'date_recorded'         => $this->faker->date(),
            'livestream_account_id' => 1
        ];
    }
}