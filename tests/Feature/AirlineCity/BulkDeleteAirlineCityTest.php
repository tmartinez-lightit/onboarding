<?php

declare(strict_types=1);

namespace Tests\Feature\AirlineCity;

use Database\Factories\AirlineFactory;
use Illuminate\Http\JsonResponse;
use Tests\RequestFactories\BulkDeleteAirlineCityRequestFactory;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\deleteJson;

describe('airline cities', function () {
    it('can delete cities from airline successfully', function () {
        $airline = AirlineFactory::new()->withCities(2)->createOne();
        $cities = $airline->cities;

        $data = BulkDeleteAirlineCityRequestFactory::new()->create([
            'cityIds' => $cities->pluck('id')->toArray(),
        ]);

        deleteJson(url("/api/airlines/{$airline->id}/cities"), $data)
            ->assertNoContent();

        foreach ($cities as $city) {
            assertDatabaseMissing('airline_city', [
                'airline_id' => $airline->id,
                'city_id' => $city->id,
            ]);
        }
    });

    it('returns validation errors when data is invalid', function (string $field, array $data, string $error) {
        $airline = AirlineFactory::new()->withCities(2)->createOne();

        deleteJson(url("/api/airlines/{$airline->id}/cities"), $data)
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
});
