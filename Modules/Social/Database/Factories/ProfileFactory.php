<?php

namespace Modules\Social\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Social\Models\Profile;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return (Factory|string)[]
     *
     * @psalm-return array{first_name: string, last_name: string, user_id: Factory<User>, bio: string}
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'user_id' => User::factory(),
            'bio' => $this->faker->text,
        ];
    }
}
