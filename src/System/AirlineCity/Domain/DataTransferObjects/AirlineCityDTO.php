<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\DataTransferObjects;

class AirlineCityDTO
{
    public function __construct(
        private readonly int $airlineId,
        private readonly int $cityId,
    ) {
    }

    public function getAirlineId(): int
    {
        return $this->airlineId;
    }

    public function getCityId(): int
    {
        return $this->cityId;
    }
}
