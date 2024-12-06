<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\Airline\Domain\Actions\ListAirlineAction;

class ListAirlineController
{
    public function __invoke(
        Request $request,
        ListAirlineAction $action,
    ): JsonResponse {
        $airlines = $action->execute();

        return responder()
            ->success($airlines, AirlineTransformer::class)
            ->respond();
    }
}
