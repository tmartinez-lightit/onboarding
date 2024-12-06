<?php

declare(strict_types=1);

namespace Tests\Feature\Airlines;

use Tests\RequestFactories\UpsertAirlineRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('airlines', function () {
    it('can store an airline successfully', function () {
        $data = UpsertAirlineRequestFactory::new()->create();

        postJson(url('/api/airlines'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        assertDatabaseHas('airlines', [
            'name' => $data['name'],
        ]);
    });

    it('returns validation error when data is invalid', function () {
        postJson(url('/api/airlines'), [])
            ->assertUnprocessable();
    });
});
