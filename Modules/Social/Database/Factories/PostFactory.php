<?php

namespace Modules\Social\Database\Factories;

use App\Models\Team;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;
use Modules\Social\Models\Profile;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return (\Illuminate\Support\Carbon|mixed|string)[]
     *
     * @psalm-return array{user_id: mixed, body: string, created_at: \Illuminate\Support\Carbon, updated_at: \Illuminate\Support\Carbon}
     */
    public function definition()
    {
        return [
            'user_id'    => User::all()->random()->id,
            'body'       => $this->faker->paragraph(4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

