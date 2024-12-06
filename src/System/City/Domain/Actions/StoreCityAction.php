<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\Actions;

use Lightit\System\City\Domain\DataTransferObjects\CityDTO;
use Lightit\System\City\Domain\Models\City;

class StoreCityAction
{
    public function execute(CityDTO $cityDTO): City
    {
        return City::create([
            'name' => $cityDTO->getName(),
        ]);
    }
}
