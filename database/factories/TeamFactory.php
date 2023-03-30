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
            'name' => $this->faker->unique()->company(),
            'content' => implode(' ', $this->faker->paragraphs(7)),
            'summary' => $this->faker->paragraph(),
            'start_date' => $this->faker->date(),
        ];
    }

    public function withUsers($amount = 1, $roleName = 'Member')
    {
        return $this->hasAttached(User::factory($amount)->withProfile(), function (Team $team) use ($roleName) {
            $role = Role::where('name', $roleName)->where('team_id', $team->id)->first();
            setPermissionsTeamId($team->id);

            if (is_null($role)) {
                $role = Role::create([
                    'name' => $roleName,
                    'team_id' => $team->id,
                ]);
            }

            return [
                'role_id' => $role->id,
            ];
        });
    }
}
