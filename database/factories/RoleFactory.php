<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Modules\Social\Models\Profile;
use Spatie\Permission\Models\Role;

class RoleFactory extends Factory
{
    protected $model = Role::class;

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
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        $teamOwnerRole = Role::create([
            'name' => config('platform.teams.default_owner_role'),
            'team'
        ]);

        return $this->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->profile->name.'\'s ' . \Trans::get('Team')];
                }),
                ['role_id' => $teamOwnerRole->id],
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
