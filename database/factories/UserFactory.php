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
     * Indicate that the user should have a personal team.
     * 
     * @param $position
     * @return $this
     */
    public function withExistingTeam($position = 'member')
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->hasAttached(
            Team::get()->shuffle()->first(), 
            ['role' => $position],
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
