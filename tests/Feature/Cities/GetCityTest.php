<?php

declare(strict_types=1);

namespace Tests\Feature\Cities;

use Database\Factories\CityFactory;
use function Pest\Laravel\getJson;

describe('cities', function () {
    it('can get a city successfully', function () {
        $city = CityFactory::new()->createOne();

        getJson(url("/api/cities/{$city->id}"))
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'id' => $city->id,
                    'name' => $city->name,
                ],
            ]);
    });

    it('returns 404 if the city does not exist', function () {
        getJson(url('/api/cities/999'))
            ->assertNotFound();
    });
});
