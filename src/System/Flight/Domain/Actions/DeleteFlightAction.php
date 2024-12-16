<?php

declare(strict_types=1);

namespace Lightit\System\Flight\Domain\Actions;

use Lightit\System\Flight\Domain\Models\Flight;

class DeleteFlightAction
{
    public function execute(Flight $flight): void
    {
        $flight->delete();
    }
}
