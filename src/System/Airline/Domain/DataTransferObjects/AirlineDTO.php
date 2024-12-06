<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\DataTransferObjects;

class AirlineDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string|null $description,
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string|null
    {
        return $this->description;
    }
}
