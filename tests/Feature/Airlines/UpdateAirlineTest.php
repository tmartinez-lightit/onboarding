<?php

declare(strict_types=1);

namespace Tests\Feature\Airlines;

use Database\Factories\AirlineFactory;
use Tests\RequestFactories\UpsertAirlineRequestFactory;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

describe('airlines', function () {
    it('can update an airline successfully', function () {
        $airline = AirlineFactory::new()->createOne(['name' => 'Old Airline Name']);

        $data = UpsertAirlineRequestFactory::new()->create([
            'name' => 'New Airline Name',
        ]);

        putJson(url("/api/airlines/{$airline->id}"), $data)
            ->assertSuccessful();

        assertDatabaseHas('airlines', [
            'id' => $airline->id,
            'name' => 'New Airline Name',
        ]);

        assertDatabaseCount('airlines', 1);
    });

    it('returns 404 if the airline does not exist', function () {
        putJson(url('/api/airlines/1'), [])
            ->assertNotFound();
    });
});
