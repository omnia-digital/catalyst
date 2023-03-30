<?php

namespace Modules\Social\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Social\Models\Post;

class MentionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Social\Models\Mention::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::all()->random();
        $post = Post::factory(1)->create([
            'body' => "Hello @{$user->handle}, I mentioned you in a post!",
        ])->first();

        return [
            'mentionable_id' => $user->id,
            'mentionable_type' => $user::class,
            'postable_id' => $post->id,
            'postable_type' => $post::class,
        ];
    }
}
