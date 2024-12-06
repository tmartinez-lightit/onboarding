<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\Actions;

use Lightit\System\Airline\Domain\DataTransferObjects\AirlineDTO;
use Lightit\System\Airline\Domain\Models\Airline;

class UpdateAirlineAction
{
    public function execute(Airline $airline, AirlineDTO $AirlineDTO): Airline
    {
        $airline->update([
            'name' => $AirlineDTO->getName(),
            'description' => $AirlineDTO->getDescription(),
        ]);

        return $airline;
    }
}
