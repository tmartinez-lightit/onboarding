<?php

declare(strict_types=1);

namespace Tests\Feature\Cities;

use Database\Factories\CityFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\City\Domain\Models\City;
use function Pest\Laravel\getJson;

describe('cities', function () {
    it('can list cities successfully', function () {
        /** @var Collection<int, City> $cities */
        $cities = CityFactory::new()
            ->count(5)
            ->create();

        $transformer = new CityTransformer();

        getJson(url('/api/cities'))
            ->assertSuccessful()
            ->assertExactJson([
                'status' => JsonResponse::HTTP_OK,
                'success' => true,
                'data' => $cities->map(fn (City $city) => $transformer->transform($city))->toArray(),
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

    it('returns an empty array if no cities exist', function () {
        getJson(url('/api/cities'))
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
