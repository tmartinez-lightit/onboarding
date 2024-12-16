<?php

declare(strict_types=1);

namespace Lightit\System\Flight\App\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Lightit\System\Flight\Domain\DataTransferObjects\FlightDTO;

class UpsertFlightRequest extends FormRequest
{
    public const AIRLINE_ID = 'airlineId';

    public const ORIGIN_CITY_ID = 'originCityId';

    public const DESTINATION_CITY_ID = 'destinationCityId';

    public const DEPARTURE_DATETIME = 'departureDatetime';

    public const ARRIVAL_DATETIME = 'arrivalDatetime';

    public function rules(): array
    {
        return [
            self::AIRLINE_ID => ['required', 'integer', 'exists:airlines,id'],
            self::ORIGIN_CITY_ID => ['required', 'integer', 'exists:cities,id'],
            self::DESTINATION_CITY_ID => [
                'required',
                'integer',
                'exists:cities,id',
                'different:' . self::ORIGIN_CITY_ID,
            ],
            self::DEPARTURE_DATETIME => ['required', 'date'],
            self::ARRIVAL_DATETIME => ['required', 'date', 'after:' . self::DEPARTURE_DATETIME],
        ];
    }

    public function toDTO(): FlightDTO
    {
        return new FlightDTO(
            airlineId: $this->integer(self::AIRLINE_ID),
            originCityId: $this->integer(self::ORIGIN_CITY_ID),
            destinationCityId: $this->integer(self::DESTINATION_CITY_ID),
            departureDatetime: Carbon::parse($this->string(self::DEPARTURE_DATETIME)->toString()),
            arrivalDatetime: Carbon::parse($this->string(self::ARRIVAL_DATETIME)->toString()),
        );
    }
}
