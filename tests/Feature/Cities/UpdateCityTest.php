<?php

declare(strict_types=1);

namespace Tests\Feature\Cities;

use Database\Factories\CityFactory;
use Tests\RequestFactories\UpsertCityRequestFactory;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\putJson;

describe('cities', function () {
    it('can update a city successfully', function () {
        $city = CityFactory::new()->createOne(['name' => 'Old City Name']);

        $data = UpsertCityRequestFactory::new()->create([
            'name' => 'New City Name',
        ]);

        putJson(url("/api/cities/{$city->id}"), $data)
            ->assertSuccessful();

        assertDatabaseHas('cities', [
            'id' => $city->id,
            'name' => 'New City Name',
        ]);

        assertDatabaseCount('cities', 1);
    });

    it('returns 404 if the city does not exist', function () {
        putJson(url('/api/cities/1'), [])
            ->assertNotFound();
    });
});
