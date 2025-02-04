<?php

declare(strict_types=1);

namespace Tests\Feature\Airlines;

use Database\Factories\AirlineFactory;
use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Models\Airline;
use function Pest\Laravel\getJson;

describe('airlines', function () {
    it('can list airlines successfully', function () {
        $airlines = AirlineFactory::new()
            ->count(5)
            ->createMany();

        $transformer = new AirlineTransformer();

        getJson(url('/api/airlines'))
            ->assertSuccessful()
            ->assertJson([
                'status' => JsonResponse::HTTP_OK,
                'success' => true,
                'data' => $airlines->map(fn (Airline $airline) => $transformer->transform($airline))->toArray(),
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

    it('returns an empty array if no airlines exist', function () {
        getJson(url('/api/airlines'))
            ->assertSuccessful()
            ->assertJson([
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
