<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\Actions;

use Lightit\System\Airline\Domain\DataTransferObjects\AirlineDTO;
use Lightit\System\Airline\Domain\Models\Airline;

class StoreAirlineAction
{
    public function execute(AirlineDTO $dto): Airline
    {
        return Airline::create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);
    }
}
