<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Airline\Domain\Actions\DeleteAirlineAction;
use Lightit\System\Airline\Domain\Models\Airline;

class DeleteAirlineController
{
    public function __invoke(Airline $airline, DeleteAirlineAction $action): JsonResponse
    {
        $action->execute($airline);

        return responder()
            ->success()
            ->respond(JsonResponse::HTTP_NO_CONTENT);
    }
}
