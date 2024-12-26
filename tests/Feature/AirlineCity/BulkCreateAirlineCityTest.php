<?php

declare(strict_types=1);

namespace Tests\Feature\AirlineCity;

use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Illuminate\Http\JsonResponse;
use Tests\RequestFactories\BulkCreateAirlineCityRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

describe('store airline cities', function () {
    it('can attach cities to airline successfully', function () {
        $airline = AirlineFactory::new()->createOne();
        $cities = CityFactory::new()->createMany(2);

        $data = BulkCreateAirlineCityRequestFactory::new()->create([
            'cityIds' => $cities->pluck('id')->toArray(),
        ]);

        postJson(url("/api/airlines/{$airline->id}/cities"), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'name',
                    'cities' => [
                        '*' => [
                            'id',
                            'name',
                        ],
                    ],
                ],
            ]);

        foreach ($cities as $city) {
            assertDatabaseHas('airline_city', [
                'airline_id' => $airline->id,
                'city_id' => $city->id,
            ]);
        }
    });

    it('returns validation errors when data is invalid', function (string $field, array $data, string $error) {
        $airline = AirlineFactory::new()->createOne();

        postJson(url("/api/airlines/{$airline->id}/cities"), $data)
            ->assertUnprocessable()
            ->assertJson([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'error' => [
                    'code' => 'validation_failed',
                    'message' => 'The given data failed to pass validation.',
                    'fields' => [
                        $field => [$error],
                    ],
                ],
            ]);
    })->with([
        'non-existent city' => [
            'field' => 'cityIds.0',
            'data' => ['cityIds' => [999999]],
            'error' => 'The selected cityIds.0 is invalid.',
        ],
        'missing cityIds' => [
            'field' => 'cityIds',
            'data' => ['cityIds' => []],
            'error' => 'The city ids field is required.',
        ],
    ]);

    it('cannot attach cities to non-existent airline', function () {
        $nonExistentAirlineId = 99999;
        $cities = CityFactory::new()->createMany(1);

        $data = BulkCreateAirlineCityRequestFactory::new()->create([
            'cityIds' => $cities->pluck('id')->toArray(),
        ]);

        postJson(url("/api/airlines/{$nonExistentAirlineId}/cities"), $data)
            ->assertNotFound();
    });

    it('cannot attach already attached cities', function () {
        $city = CityFactory::new()->createOne();
        $airline = AirlineFactory::new()->createOne();
        $airline->cities()->attach($city);

        $data = BulkCreateAirlineCityRequestFactory::new()->create([
            'cityIds' => [$city->id],
        ]);

        postJson(url("/api/airlines/{$airline->id}/cities"), $data)
            ->assertUnprocessable()
            ->assertJson([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'success' => false,
                'error' => [
                    'code' => 'validation_failed',
                    'message' => 'The given data failed to pass validation.',
                    'fields' => [
                        'cityIds' => ["Cities with IDs ({$city->id}) are already attached to this airline"],
                    ],
                ],
            ]);
    });

    it('cannot attach cities to airline with invalid city ids', function () {
        $airline = AirlineFactory::new()->createOne();
        $data = BulkCreateAirlineCityRequestFactory::new()->create([
            'cityIds' => [999999],
        ]);

        postJson(url("/api/airlines/{$airline->id}/cities"), $data)->assertUnprocessable();
    });
});
