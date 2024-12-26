<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;

class BulkDeleteAirlineCityRequest extends FormRequest
{
    public const CITY_IDS = 'cityIds';

    public function rules(): array
    {
        return [
            self::CITY_IDS => ['required', 'array'],
            self::CITY_IDS . '.*' => ['required', 'integer', 'exists:cities,id'],
        ];
    }

    public function after(): array
    {
        return [
            function () {
                /** @var Airline $airline */
                $airline = $this->route('airline');
                $existingCities = $airline
                    ->cities()
                    ->whereIn('city_id', $this->input(self::CITY_IDS))
                    ->pluck('city_id');

                $citiesNotAttachedToAirline = collect((array) $this->input(self::CITY_IDS))->diff($existingCities);

                if ($citiesNotAttachedToAirline->isNotEmpty()) {
                    $this->validator->errors()->add(
                        'cityIds',
                        'Cities with IDs (' . $citiesNotAttachedToAirline->join(
                            ', '
                        ) . ') are not attached to this airline'
                    );
                }
            },
        ];
    }

    public function toDTO(): AirlineCityDTO
    {
        return new AirlineCityDTO(
            cityIds: (array) $this->input(self::CITY_IDS),
        );
    }
}
