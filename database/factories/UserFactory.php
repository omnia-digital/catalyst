<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Modules\Social\Models\Profile;
use Nwidart\Modules\Module;
use Spatie\Permission\Models\Role;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }

    /**
     * Indicate that the user should have a personal team.
     * 
     * @return $this
     */
    public function withTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        $team = Team::factory()->create();

        $role = Role::create([
            'name' => config('platform.teams.default_owner_role'),
            'team_id' => $team->id
        ]);

        return $this->hasAttached(
            $team,
            ['role_id' => $role->id, 'team_id' => $team->id],
            'teams'
        );
    }

    /**
     * Indicate that the user should have a personal team.
     * 
     * @param $position
     * @return $this
     */
    public function withExistingTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }
        $team = Team::get()->shuffle()->first();

        $member = config('platform.teams.default_member_role');

        setPermissionsTeamId($team->id);

        return $this->hasAttached(
            $team, 
            ['role_id' => Role::findOrCreate($member)->id, 'team_id' => $team->id],
            'teams'
        );
    }

    /**
     * Indicate that the user should have a profile.
     *
     * @return $this
     */
    public function withProfile()
    {
        if (!class_exists(\Modules\Social\Models\Profile::class)) return;

        return $this->has(
            Profile::factory()
                ->state(function (array $attributes, User $user) {
                    return [
                        'user_id' => $user->id,
                        'first_name' => $attributes['first_name'],
                        'last_name' => $attributes['last_name'],
                    ];
                })
        );
    }
}
