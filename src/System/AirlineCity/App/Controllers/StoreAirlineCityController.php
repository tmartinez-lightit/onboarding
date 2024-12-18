<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\AirlineCity\App\Requests\StoreAirlineCityRequest;
use Lightit\System\AirlineCity\App\Transformers\AirlineCityTransformer;
use Lightit\System\AirlineCity\Domain\Actions\StoreAirlineCityAction;

class StoreAirlineCityController
{
    public function __invoke(StoreAirlineCityRequest $request, StoreAirlineCityAction $action): JsonResponse
    {
        $airlineCity = $action->execute($request->toDTO());

        return responder()
            ->success($airlineCity, AirlineCityTransformer::class)
            ->respond(JsonResponse::HTTP_CREATED);
    }
}
