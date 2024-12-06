<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\City\Domain\Actions\ListCityAction;

class ListCityController
{
    public function __invoke(
        Request $request,
        ListCityAction $action,
    ): JsonResponse {
        $cities = $action->execute();

        return responder()
            ->success($cities, CityTransformer::class)
            ->respond();
    }
}
