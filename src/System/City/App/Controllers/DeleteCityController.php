<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Lightit\System\City\Domain\Actions\DeleteCityAction;
use Lightit\System\City\Domain\Models\City;

class DeleteCityController
{
    public function __invoke(City $city, DeleteCityAction $action): JsonResponse
    {
        $action->execute($city);

        return responder()
            ->success()
            ->respond(JsonResponse::HTTP_NO_CONTENT);
    }
}
