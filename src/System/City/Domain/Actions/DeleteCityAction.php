<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\Actions;

use Lightit\System\City\Domain\Models\City;

class DeleteCityAction
{
    public function execute(City $city): void
    {
        $city->delete();
    }
}
