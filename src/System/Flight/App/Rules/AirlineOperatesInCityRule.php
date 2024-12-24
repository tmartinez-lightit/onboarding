<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Lightit\System\Airline\Domain\Models\Airline;

class AirlineOperatesInCityRule implements Rule
{
    private readonly Airline|null $airline;

    public function __construct(int $airlineId)
    {
        $this->airline = Airline::find($airlineId);
    }

    public function passes($attribute, $value): bool
    {
        if (! $this->airline) {
            return false;
        }

        return $this->airline->cities()->where('id', $value)->exists();
    }

    public function message(): string
    {
        return 'The airline does not operate in this city.';
    }
}
