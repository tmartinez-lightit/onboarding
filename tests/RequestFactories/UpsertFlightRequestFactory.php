<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Carbon\CarbonImmutable;
use Worksome\RequestFactories\RequestFactory;

class UpsertFlightRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $departure = CarbonImmutable::instance(fake()->dateTimeBetween('now', '+30 days'));
        $arrival = CarbonImmutable::instance(fake()->dateTimeBetween($departure, $departure->addDays(1)));

        return [
            'airlineId' => $this->faker->numberBetween(1, 100),
            'originCityId' => $this->faker->numberBetween(1, 100),
            'destinationCityId' => $this->faker->numberBetween(1, 100),
            'departureDatetime' => $departure,
            'arrivalDatetime' => $arrival,
        ];
    }
}
