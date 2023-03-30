<?php

namespace Modules\Social\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Social\Enums\PostType;
use Modules\Social\Models\Post;

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
            'user_id' => User::all()->random()->id,
            'body' => $this->faker->paragraph(4),
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
            'type' => $type,
        ]);
    }

    public function asResource(): PostFactory
    {
        return $this->withType(PostType::ARTICLE)->state([
            'title' => $this->faker->company(),
        ]);
    }

    public function asQuestion(): PostFactory
    {
        return $this->withType(PostType::QUESTION)->state([
            'title' => $this->faker->sentence,
            'body' => $this->faker->paragraph(6),
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
                        'postable_id' => $post->id,
                        'postable_type' => Post::class,
                    ];
                })
        );
    }
}
