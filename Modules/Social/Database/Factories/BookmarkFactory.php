<?php

namespace Modules\Social\Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Social\Models\Bookmark;
use Modules\Social\Models\Post;

class BookmarkFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bookmark::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           => User::all()->random()->id,
            'bookmarkable_id'   => Post::all()->random()->id,
            'bookmarkable_type' => Post::class,
            'created_at'        => now(),
            'updated_at'        => now(),
        ];
    }
}

