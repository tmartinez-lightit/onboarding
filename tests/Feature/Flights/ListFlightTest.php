<?php

declare(strict_types=1);

namespace Tests\Feature\Flights;

use Database\Factories\FlightFactory;
use Illuminate\Http\JsonResponse;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use Lightit\System\Flight\Domain\Models\Flight;
use function Pest\Laravel\getJson;

describe('flights', function () {
    it('can list flights successfully', function () {
        $flights = FlightFactory::new()
            ->count(5)
            ->createMany();

        $transformer = new FlightTransformer();

        getJson(url('/api/flights'))
            ->assertSuccessful()
            ->assertJson([
                'status' => JsonResponse::HTTP_OK,
                'success' => true,
                'data' => $flights->map(fn (Flight $flight) => $transformer->transform($flight))->toArray(),
                'pagination' => [
                    'count' => 5,
                    'currentPage' => 1,
                    'links' => [],
                    'perPage' => 15,
                    'total' => 5,
                    'totalPages' => 1,
                ],
            ]);
    });

    it('returns an empty array if no flights exist', function () {
        getJson(url('/api/flights'))
            ->assertSuccessful()
            ->assertExactJson([
                'status' => JsonResponse::HTTP_OK,
                'success' => true,
                'data' => [],
                'pagination' => [
                    'count' => 0,
                    'currentPage' => 1,
                    'links' => [],
                    'perPage' => 15,
                    'total' => 0,
                    'totalPages' => 1,
                ],
            ]);
    });
});
