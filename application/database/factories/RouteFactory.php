<?php

namespace Database\Factories;

use App\Models\Airport;
use App\Models\Route;
use Illuminate\Database\Eloquent\Factories\Factory;

class RouteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Route::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'airline' => 'CG',
            'airline_id' => $this->faker->randomDigitNotZero(),
            'source_airport' => $this->faker->company(),
            'destination_airport' => $this->faker->company(),
            'codeshare' => 'Y',
            'stops' => 0,
            'equipment' => $this->faker->randomLetter(),
            'price' => $this->faker->randomDigitNotNull()

        ];
    }
}
