<?php

namespace Modules\Social\Database\Factories;

use App\Models\Team;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Laravel\Jetstream\Features;
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
     * @return array
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

    /**
     * @return $this
     */
    public function withType($type): static
    {
        return $this->state([
            'type' => $type
        ]);
    }

    /**
     * @return $this
     */
    public function withReplies($replies = 5)
    {
        return $this->has(
            Post::factory($replies)
                ->state(function (array $attributes, Post $post) {
                    return [
                        'postable_id'   => $post->id,
                        'postable_type' => Post::class,
                    ];
                })
        );
    }
}

