<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\City\Domain\Models\City;
use Lightit\System\Flight\App\Transformers\FlightTransformer;

class CityTransformer extends Transformer
{
    protected $relations = [
        'outgoingFlights' => FlightTransformer::class,
        'incomingFlights' => FlightTransformer::class,
        'airlines' => AirlineTransformer::class,
    ];

    public function transform(City $city): array
    {
        return [
            'id' => $city->id,
            'name' => $city->name,
        ];
    }
}
