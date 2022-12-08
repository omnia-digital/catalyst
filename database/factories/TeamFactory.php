<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;

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
            'name'       => $this->faker->unique()->company(),
            'content'    => implode(' ', $this->faker->paragraphs(7)),
            'summary'    => $this->faker->paragraph(),
            'start_date' => $this->faker->date(),
        ];
    }

    public function withUsers($amount = 1)
    {
        return $this->hasAttached(User::factory($amount)->withProfile(), function(Team $team) {
            setPermissionsTeamId($team->id);
            return [
                'role_id' => Role::findOrCreate(config('platform.teams.default_owner_role'))->id,
                'model_type' => User::class,
            ];
        });

    }
}
