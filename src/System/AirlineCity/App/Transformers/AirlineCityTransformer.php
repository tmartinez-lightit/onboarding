<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\AirlineCity\Domain\Models\AirlineCity;

class AirlineCityTransformer extends Transformer
{
    public function transform(AirlineCity $airlineCity): array
    {
        return [
            'airline_id' => $airlineCity->airline_id,
            'city_id' => $airlineCity->city_id,
        ];
    }
}
