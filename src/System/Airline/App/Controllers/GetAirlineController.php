<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Models\Airline;

class GetAirlineController
{
    public function __invoke(Airline $airline): JsonResponse
    {
        return responder()->success($airline, AirlineTransformer::class)->respond();
    }
}
