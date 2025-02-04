<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\City\App\Transformers\CityTransformer;
use Lightit\System\Flight\App\Transformers\FlightTransformer;

class AirlineTransformer extends Transformer
{
    protected $relations = [
        'cities' => CityTransformer::class,
        'flights' => FlightTransformer::class,
    ];

    public function transform(Airline $airline): array
    {
        return [
            'id' => $airline->id,
            'name' => $airline->name,
            'description' => $airline->description,
            'activeFlightsCount' => $airline->active_flights_count,
        ];
    }
}
