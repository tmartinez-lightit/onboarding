<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\Actions;

use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;

class BulkDeleteAirlineCityAction
{
    public function execute(Airline $airline, AirlineCityDTO $airlineCityDTO): void
    {
        $airline->cities()->detach($airlineCityDTO->getCityIds());
    }
}
