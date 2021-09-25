<?php

namespace Database\Factories;

use App\Models\Airport;
use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

class AirportFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Airport::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'iata' => 'SDR',
            'icao' => 'FGR',
            'dst' => 'E',
            'tz' => 'adc',
            'latitude' => 34.4324234234234,
            'longitude' => 3.93837663,
            'altitude' => 30,
            'timezone' => 2,
            'type' => 'airport',
            'source' => 'OurAirports',
            'city_id' => City::factory()->create()->id,
        ];
    }
}
