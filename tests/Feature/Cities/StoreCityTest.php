<?php

declare(strict_types=1);

namespace Tests\Feature\Cities;

use Tests\RequestFactories\UpsertCityRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('cities', function () {
    it('can store a city successfully', function () {
        $data = UpsertCityRequestFactory::new()->create();

        postJson(url('/api/cities'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                ],
            ]);

        assertDatabaseHas('cities', [
            'name' => $data['name'],
        ]);
    });

    it('returns validation error when data is invalid', function () {
        postJson(url('/api/cities'), [])
            ->assertUnprocessable();
    });
});
