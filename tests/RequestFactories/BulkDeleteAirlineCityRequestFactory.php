<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Database\Factories\CityFactory;
use Worksome\RequestFactories\RequestFactory;

class BulkDeleteAirlineCityRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        $cities = CityFactory::new()->createMany(2);

        return [
            'cityIds' => $cities->pluck('id')->toArray(),
        ];
    }
}
