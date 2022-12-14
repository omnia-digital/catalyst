<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
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

    public function withUsers($amount = 1, $role = 'Member')
    {
        return $this->hasAttached(User::factory($amount)->withProfile(), function(Team $team) use ($role) {
            setPermissionsTeamId($team->id);
            return [
                'role_id' => Role::findOrCreate($role)->id,
            ];
        });

    }
}
