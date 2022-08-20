<?php
namespace Modules\Reviews\Database\factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Reviews\Models\Review::class;

    /**
     * Define the model's default state.
     *
     * @return (\Illuminate\Support\Carbon|mixed|string)[]
     *
     * @psalm-return array{user_id: mixed, reviewable_id: mixed, reviewable_type: Team::class, body: string, created_at: \Illuminate\Support\Carbon, updated_at: \Illuminate\Support\Carbon}
     */
    public function definition()
    {
        return [
            'user_id'    => User::all()->random()->id,
            'reviewable_id'    => Team::all()->random()->id,
            'reviewable_type' => Team::class,
            'body'       => $this->faker->paragraph(4),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

