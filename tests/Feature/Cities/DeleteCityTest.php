<?php

declare(strict_types=1);

namespace Tests\Feature\Cities;

use Database\Factories\CityFactory;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('cities', function () {
    it('can delete a city successfully', function () {
        $city = CityFactory::new()->createOne();

        deleteJson(url("/api/cities/{$city->id}"))
            ->assertSuccessful();

        assertDatabaseMissing('cities', [
            'id' => $city->id,
        ]);
    });

    it('returns 404 if the city does not exist', function () {
        deleteJson(url('/api/cities/1'))
            ->assertNotFound();
    });
});
