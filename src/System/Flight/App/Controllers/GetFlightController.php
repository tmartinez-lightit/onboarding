<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Flight\App\Transformers\FlightTransformer;
use Lightit\System\Flight\Domain\Models\Flight;

class GetFlightController
{
    public function __invoke(Flight $flight): JsonResponse
    {
        return responder()
            ->success($flight, FlightTransformer::class)
            ->respond();
    }
}
