<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\AirlineCity\App\Requests\BulkDeleteAirlineCityRequest;
use Lightit\System\AirlineCity\Domain\Actions\BulkDeleteAirlineCityAction;

class BulkDeleteAirlineCityController
{
    public function __invoke(
        Airline $airline,
        BulkDeleteAirlineCityRequest $request,
        BulkDeleteAirlineCityAction $action,
    ): JsonResponse {
        $action->execute($airline, $request->toDTO());

        return responder()
            ->success()
            ->respond(JsonResponse::HTTP_NO_CONTENT);
    }
}
