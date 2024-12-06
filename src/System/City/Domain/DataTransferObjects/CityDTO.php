<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\DataTransferObjects;

class CityDTO
{
    public function __construct(
        private readonly string $name,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
