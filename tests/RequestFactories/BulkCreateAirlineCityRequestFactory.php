<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Database\Factories\CityFactory;
use Worksome\RequestFactories\RequestFactory;

class BulkCreateAirlineCityRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $city = CityFactory::new()->createOne();

        return [
            'cityIds' => [$city->id],
        ];
    }
}
