<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\Actions;

use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;

class ToggleAirlineCityAction
{
    public function execute(Airline $airline, AirlineCityDTO $airlineCityDTO): Airline
    {
        $cityIds = $airlineCityDTO->getCityIds();
        $existingCityIds = $airline->load('cities')
            ->cities()
            ->whereIn('city_id', $cityIds)
            ->pluck('city_id')
            ->toArray();

        $citiesToAttach = array_diff($cityIds, $existingCityIds);
        $citiesToDetach = array_intersect($cityIds, $existingCityIds);

        if (! empty($citiesToAttach)) {
            $airline->cities()->attach($citiesToAttach);
        }

        if (! empty($citiesToDetach)) {
            $airline->cities()->detach($citiesToDetach);
        }

        return $airline;
    }
}
