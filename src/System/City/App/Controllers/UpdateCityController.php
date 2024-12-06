<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\City\App\Request\UpsertCityRequest;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\City\Domain\Actions\UpdateCityAction;
use Lightit\System\City\Domain\Models\City;

class UpdateCityController
{
    public function __invoke(City $city, UpsertCityRequest $request, UpdateCityAction $action): JsonResponse
    {
        $city = $action->execute($city, $request->toDTO());

        return responder()
            ->success($city, CityTransformer::class)
            ->respond();
    }
}
