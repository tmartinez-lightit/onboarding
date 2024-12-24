<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\DataTransferObjects;

class AirlineCityDTO
{
    public function __construct(
        private readonly array $cityIds,
    ) {
    }

    /**
     * @return int[]
     */
    public function getCityIds(): array
    {
        return $this->cityIds;
    }
}
