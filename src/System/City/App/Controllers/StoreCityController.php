<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\City\App\Request\UpsertCityRequest;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\City\Domain\Actions\StoreCityAction;

class StoreCityController
{
    public function __invoke(UpsertCityRequest $request, StoreCityAction $action): JsonResponse
    {
        $city = $action->execute($request->toDTO());

        return responder()
            ->success($city, CityTransformer::class)
            ->respond(JsonResponse::HTTP_CREATED);
    }
}
