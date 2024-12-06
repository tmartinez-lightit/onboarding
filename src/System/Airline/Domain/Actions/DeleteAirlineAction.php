<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\Actions;

use Lightit\System\Airline\Domain\Models\Airline;

class DeleteAirlineAction
{
    public function execute(Airline $airline): void
    {
        $airline->delete();
    }
}
