<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\Airline\App\Transformers\AirlineTransformer;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\Flight\Domain\Models\Flight;

class FlightTransformer extends Transformer
{
    protected $relations = [
        'airline' => AirlineTransformer::class,
        'originCity' => CityTransformer::class,
        'destinationCity' => CityTransformer::class,
    ];

    public function transform(Flight $flight): array
    {
        return [
            'id' => $flight->id,
            'airlineId' => $flight->airline_id,
            'originCityId' => $flight->origin_city_id,
            'destinationCityId' => $flight->destination_city_id,
            'departureDatetime' => $flight
                ->departure_datetime
                ->format((string) config('date-format.default')),
            'arrivalDatetime' => $flight
                ->arrival_datetime
                ->format((string) config('date-format.default')),
        ];
    }
}
