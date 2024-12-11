<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use Lightit\System\Flight\Domain\Actions\ListFlightAction;

class ListFlightController
{
    public function __invoke(
        Request $request,
        ListFlightAction $action,
    ): JsonResponse {
        $flights = $action->execute();

        return responder()
            ->success($flights, FlightTransformer::class)
            ->respond();
    }
}
