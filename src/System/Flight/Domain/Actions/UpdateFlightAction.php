<?php

declare(strict_types=1);

namespace Lightit\System\Flight\Domain\Actions;

use Lightit\System\Flight\Domain\DataTransferObjects\FlightDTO;
use Lightit\System\Flight\Domain\Models\Flight;

class UpdateFlightAction
{
    public function execute(Flight $flight, FlightDTO $flightDTO): Flight
    {
        $flight->update([
            'airline_id' => $flightDTO->getAirlineId(),
            'origin_city_id' => $flightDTO->getOriginCityId(),
            'destination_city_id' => $flightDTO->getDestinationCityId(),
            'departure_datetime' => $flightDTO->getDepartureDatetime(),
            'arrival_datetime' => $flightDTO->getArrivalDatetime(),
        ]);

        return $flight;
    }
}
