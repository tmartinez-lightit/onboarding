<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\App\Request\UpsertAirlineRequest;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Actions\UpdateAirlineAction;
use Lightit\System\Airline\Domain\Models\Airline;

class UpdateAirlineController
{
    public function __invoke(Airline $airline, UpsertAirlineRequest $request, UpdateAirlineAction $action): JsonResponse
    {
        $airline = $action->execute($airline, $request->toDTO());

        return responder()
            ->success($airline, AirlineTransformer::class)
            ->respond();
    }
}
