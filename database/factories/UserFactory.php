<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use Modules\Social\Models\Profile;
use Nwidart\Modules\Module;

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
     * @return (\Illuminate\Support\Carbon|string)[]
     *
     * @psalm-return array{email: string, email_verified_at: \Illuminate\Support\Carbon, password: string, remember_token: string}
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
     * Indicate that the user should have a personal team.
     *
     * @return $this
     */
    public function withTeam()
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->hasAttached(
            Team::factory()
                ->state(function (array $attributes, User $user) {
                    return ['name' => $user->profile->name.'\'s ' . \Trans::get('Team')];
                }), 
                ['role' => 'owner'],
                'teams'
        );
    }
}
