<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\Actions;

use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;
use Lightit\System\AirlineCity\Domain\Models\AirlineCity;

class StoreAirlineCityAction
{
    public function execute(AirlineCityDTO $airlineCityDTO): AirlineCity
    {
        return AirlineCity::create([
            'airline_id' => $airlineCityDTO->getAirlineId(),
            'city_id' => $airlineCityDTO->getCityId(),
        ]);
    }
}
