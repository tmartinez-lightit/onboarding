<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Flight\App\Request\UpsertFlightRequest;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use Lightit\System\Flight\Domain\Actions\UpdateFlightAction;
use Lightit\System\Flight\Domain\Models\Flight;

class UpdateFlightController
{
    public function __invoke(Flight $flight, UpsertFlightRequest $request, UpdateFlightAction $action): JsonResponse
    {
        $updatedFlight = $action->execute($flight, $request->toDTO());

        return responder()
            ->success($updatedFlight, FlightTransformer::class)
            ->respond();
    }
}
