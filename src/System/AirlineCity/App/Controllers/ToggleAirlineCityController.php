<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\AirlineCity\App\Requests\ToggleAirlineCityRequest;
use Lightit\System\AirlineCity\Domain\Actions\ToggleAirlineCityAction;

class ToggleAirlineCityController
{
    public function __invoke(
        Airline $airline,
        ToggleAirlineCityRequest $request,
        ToggleAirlineCityAction $action,
    ): JsonResponse {
        $airline = $action->execute($airline, $request->toDTO());

        return responder()
            ->success($airline, AirlineTransformer::class)
            ->with('cities')
            ->respond(JsonResponse::HTTP_OK);
    }
}
