<?php

declare(strict_types=1);

namespace Lightit\System\Flight\Domain\DataTransferObjects;

use Illuminate\Support\Carbon;

class FlightDTO
{
    public function __construct(
        private readonly int $airlineId,
        private readonly int $originCityId,
        private readonly int $destinationCityId,
        private readonly Carbon $departureDatetime,
        private readonly Carbon $arrivalDatetime,
    ) {
    }

    public function getAirlineId(): int
    {
        return $this->airlineId;
    }

    public function getOriginCityId(): int
    {
        return $this->originCityId;
    }

    public function getDestinationCityId(): int
    {
        return $this->destinationCityId;
    }

    public function getDepartureDatetime(): Carbon
    {
        return $this->departureDatetime;
    }

    public function getArrivalDatetime(): Carbon
    {
        return $this->arrivalDatetime;
    }
}
