<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\City\Domain\Models\City;

class GetCityController
{
    public function __invoke(City $city): JsonResponse
    {
        return responder()
            ->success($city, CityTransformer::class)
            ->respond();
    }
}
