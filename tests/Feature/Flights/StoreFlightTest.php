<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Tests\RequestFactories\UpsertFlightRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\postJson;

describe('flights', function () {
    it('can store a flight successfully', function () {
        $airline = AirlineFactory::new()->createOne();
        $originCity = CityFactory::new()->createOne();
        $destinationCity = CityFactory::new()->createOne();
        $airline->cities()->attach($originCity);
        $airline->cities()->attach($destinationCity);

        $data = UpsertFlightRequestFactory::new()->state([
            'airlineId' => $airline->id,
            'originCityId' => $originCity->id,
            'destinationCityId' => $destinationCity->id,
        ])->create();

        postJson(url('/api/flights'), $data)
            ->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    'id',
                    'airlineId',
                    'originCityId',
                    'destinationCityId',
                    'departureDatetime',
                    'arrivalDatetime',
                ],
            ]);

        assertDatabaseHas('flights', [
            'airline_id' => $airline->id,
            'origin_city_id' => $originCity->id,
            'destination_city_id' => $destinationCity->id,
            'departure_datetime' => $data['departureDatetime'],
            'arrival_datetime' => $data['arrivalDatetime'],
        ]);
    });

    it('returns validations errors when data is invalid', function (string $field, mixed $value, string $error) {
        $data = UpsertFlightRequestFactory::new()->create([
            $field => $value,
        ]);

        postJson(url('/api/flights'), $data)
            ->assertUnprocessable()
            ->assertJson([
                'status' => 422,
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
        'invalid airline' => ['airlineId', 999999, 'The selected airline id is invalid.'],
        'missing airline' => ['airlineId', null, 'The airline id field is required.'],
        'invalid origin city' => ['originCityId', 999999, 'The selected origin city id is invalid.'],
        'invalid destination city' => ['destinationCityId', 999999, 'The selected destination city id is invalid.'],
        'invalid departure date' => [
            'departureDatetime',
            'not-a-date',
            'The departure datetime field must be a valid date.',
        ],
        'invalid arrival date' => ['arrivalDatetime', 'not-a-date', 'The arrival datetime field must be a valid date.'],
        'arrival date before departure date' => [
            'arrivalDatetime',
            '2024-01-01 00:00:00',
            'The arrival datetime field must be a date after departure datetime.',
        ],
    ]);

    it('returns error when origin city is the same as destination city', function () {
        $originCity = CityFactory::new()->createOne();

        $data = UpsertFlightRequestFactory::new()->state([
            'originCityId' => $originCity->id,
            'destinationCityId' => $originCity->id,
        ])->create();

        postJson(url('/api/flights'), $data)
            ->assertUnprocessable()
            ->assertJson([
                'status' => 422,
                'success' => false,
                'error' => [
                    'code' => 'validation_failed',
                    'message' => 'The given data failed to pass validation.',
                    'fields' => [
                        'destinationCityId' => [
                            'The destination city id field and origin city id must be different.',
                        ],
                    ],
                ],
            ]);

        assertDatabaseMissing('flights', [
            'origin_city_id' => $originCity->id,
            'destination_city_id' => $originCity->id,
        ]);
    });
});
