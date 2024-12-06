<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\Actions;

use Lightit\System\City\Domain\DataTransferObjects\CityDTO;
use Lightit\System\City\Domain\Models\City;

class UpdateCityAction
{
    public function execute(City $city, CityDTO $CityDTO): City
    {
        $city->update([
            'name' => $CityDTO->getName(),
        ]);

        return $city;
    }
}
