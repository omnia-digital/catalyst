<?php
namespace Modules\Social\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Social\Models\Post;

class CommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Social\Models\Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::all()->random()->id,
            'parent_id' => null,
            'body' => $this->faker->paragraph(4),
            'commentable_id' => Post::all()->random()->id,
            'commentable_type' => Post::class,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

