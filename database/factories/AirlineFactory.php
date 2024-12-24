<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\System\Airline\Domain\Models\Airline;
use Database\Factories\CityFactory;

/**
 * @extends Factory<Airline>
 */
class AirlineFactory extends Factory
{
    protected $model = Airline::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'description' => fake()->paragraph(),
        ];
    }

    public function withCities(int $count = 3): self
    {
        return $this->afterCreating(function (Airline $airline) use ($count) {
            $airline->cities()->attach(
                CityFactory::new()->count($count)->createMany()
            );
        });
    }
}
