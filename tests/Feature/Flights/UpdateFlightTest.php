<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\AirlineFactory;
use Database\Factories\CityFactory;
use Database\Factories\FlightFactory;
use Illuminate\Http\JsonResponse;
use Tests\RequestFactories\UpsertFlightRequestFactory;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\assertDatabaseMissing;
use function Pest\Laravel\putJson;

describe('flights', function () {
    it('can update a flight successfully', function () {
        $flight = FlightFactory::new()->createOne();
        $newAirline = AirlineFactory::new()->createOne();
        $newOriginCity = CityFactory::new()->createOne();
        $newDestinationCity = CityFactory::new()->createOne();
        $newAirline->cities()->attach($newOriginCity);
        $newAirline->cities()->attach($newDestinationCity);

        $data = UpsertFlightRequestFactory::new()->state([
            'airlineId' => $newAirline->id,
            'originCityId' => $newOriginCity->id,
            'destinationCityId' => $newDestinationCity->id,
        ])->create();

        putJson(url("/api/flights/{$flight->id}"), $data)
            ->assertOk()
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
            'id' => $flight->id,
            'airline_id' => $newAirline->id,
            'origin_city_id' => $newOriginCity->id,
            'destination_city_id' => $newDestinationCity->id,
            'departure_datetime' => $data['departureDatetime'],
            'arrival_datetime' => $data['arrivalDatetime'],
        ]);

        assertDatabaseMissing('flights', [
            'id' => $flight->id,
            'airline_id' => $flight->airline_id,
            'origin_city_id' => $flight->origin_city_id,
            'destination_city_id' => $flight->destination_city_id,
        ]);
    });

    it('returns validation errors when data is invalid', function (string $field, mixed $value, string $error) {
        $flight = FlightFactory::new()->createOne();

        $data = UpsertFlightRequestFactory::new()->create([
            $field => $value,
        ]);

        putJson(url("/api/flights/{$flight->id}"), $data)
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
        $flight = FlightFactory::new()->createOne();
        $city = CityFactory::new()->createOne();

        $data = UpsertFlightRequestFactory::new()->state([
            'originCityId' => $city->id,
            'destinationCityId' => $city->id,
        ])->create();

        putJson(url("/api/flights/{$flight->id}"), $data)
            ->assertUnprocessable()
            ->assertJson([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
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
            'id' => $flight->id,
            'origin_city_id' => $city->id,
            'destination_city_id' => $city->id,
        ]);
    });

    it('returns not found when flight does not exist', function () {
        $data = UpsertFlightRequestFactory::new()->create();

        putJson(url('/api/flights/99999'), $data)
            ->assertNotFound();
    });
});
