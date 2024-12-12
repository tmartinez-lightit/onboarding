<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\FlightFactory;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use function Pest\Laravel\getJson;

describe('flights', function () {
    it('can get a flight successfully', function () {
        $flight = FlightFactory::new()->createOne();

        $transformer = new FlightTransformer();

        $transformedFlight = $transformer->transform($flight);

        getJson(url("/api/flights/{$flight->id}"))
            ->assertSuccessful()
            ->assertJson([
                'data' => $transformedFlight,
            ]);
    });

    it('returns 404 if the flight does not exist', function () {
        getJson(url('/api/flights/999'))
            ->assertNotFound();
    });
});
