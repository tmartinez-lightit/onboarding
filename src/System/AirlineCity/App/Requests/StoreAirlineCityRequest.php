<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;

class StoreAirlineCityRequest extends FormRequest
{
    public const AIRLINE_ID = 'airlineId';

    public const CITY_ID = 'cityId';

    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['required', 'integer', 'exists:airlines,id'],
            self::CITY_ID => ['required', 'integer', 'exists:cities,id'],
        ];
    }

    public function toDTO(): AirlineCityDTO
    {
        return new AirlineCityDTO(
            airlineId: $this->integer(self::AIRLINE_ID),
            cityId: $this->integer(self::CITY_ID),
        );
    }
}
