<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\Flight\Domain\Actions\DeleteFlightAction;
use Lightit\System\Flight\Domain\Models\Flight;

class DeleteFlightController
{
    public function __invoke(Flight $flight, DeleteFlightAction $action): JsonResponse
    {
        $action->execute($flight);

        return responder()
            ->success()
            ->respond(JsonResponse::HTTP_NO_CONTENT);
    }
}
