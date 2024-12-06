<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\App\Request\UpsertAirlineRequest;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Actions\StoreAirlineAction;

class StoreAirlineController
{
    public function __invoke(
        UpsertAirlineRequest $request,
        StoreAirlineAction $action,
    ): JsonResponse {
        $airline = $action->execute($request->toDTO());

        return responder()
            ->success($airline, AirlineTransformer::class)
            ->respond(JsonResponse::HTTP_CREATED);
    }
}
