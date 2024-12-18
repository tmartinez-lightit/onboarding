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

        $airline = AirlineFactory::new()->createOne();
        $originCity = CityFactory::new()->createOne();
        $destinationCity = CityFactory::new()->createOne();

        return [
            'airline_id' => $airline->id,
            'origin_city_id' => $originCity->id,
            'destination_city_id' => $destinationCity->id,
            'departure_datetime' => $departure,
            'arrival_datetime' => $arrival,
        ];
    }
}
