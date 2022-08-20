<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class LocationFactory extends Factory
{
    /**
     * @var string
     *
     * @psalm-var Location::class
     */
    protected string $model = Location::class;

    /**
     * @return (Carbon|float|mixed|null|string)[]
     *
     * @psalm-return array{address: string, address_line_2: null, city: string, state: mixed, postal_code: string, country: string, lat: float, lng: float, created_at: Carbon, updated_at: Carbon}
     */
    public function definition(): array
    {
        return [
            'address' => $this->faker->streetAddress(),
            'address_line_2' => null,
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->countryCode(),
            'lat' => $this->faker->latitude(),
            'lng' => $this->faker->longitude(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
