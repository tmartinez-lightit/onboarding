<?php

declare(strict_types=1);

namespace Database\Factories;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\System\Flight\Domain\Models\Flight;

/**
 * @extends Factory<Flight>
 */
class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition(): array
    {
        $departure = CarbonImmutable::instance(fake()->dateTimeBetween('now', '+30 days'));
        $arrival = CarbonImmutable::instance(fake()->dateTimeBetween($departure, $departure->addDays(1)));

        return [
            'airline_id' => AirlineFactory::new(),
            'origin_city_id' => CityFactory::new(),
            'destination_city_id' => CityFactory::new(),
            'departure_datetime' => $departure,
            'arrival_datetime' => $arrival,
        ];
    }
}
