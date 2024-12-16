<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\FlightFactory;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('flights', function () {
    it('can delete a flight successfully', function () {
        $flight = FlightFactory::new()->createOne();

        deleteJson(url("/api/flights/{$flight->id}"))
            ->assertSuccessful();

        assertDatabaseMissing('flights', [
            'id' => $flight->id,
        ]);
    });

    it('returns 404 if the flight does not exist', function () {
        deleteJson(url('/api/flights/999999'))
            ->assertNotFound();
    });
});
