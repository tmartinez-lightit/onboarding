<?php

declare(strict_types=1);

namespace Tests\RequestFactories;

use Worksome\RequestFactories\RequestFactory;

class UpsertAirlineRequestFactory extends RequestFactory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->company . ' Airlines',
        ];
    }
}
