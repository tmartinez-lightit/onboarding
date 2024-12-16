<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Flight\App\Request\UpsertFlightRequest;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use Lightit\System\Flight\Domain\Actions\StoreFlightAction;

class StoreFlightController
{
    public function __invoke(UpsertFlightRequest $request, StoreFlightAction $action): JsonResponse
    {
        $flight = $action->execute($request->toDTO());

        return responder()
            ->success($flight, FlightTransformer::class)
            ->respond(JsonResponse::HTTP_CREATED);
    }
}
