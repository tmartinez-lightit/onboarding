<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Lightit\System\AirlineCity\Domain\DataTransferObjects\AirlineCityDTO;

class ToggleAirlineCityRequest extends FormRequest
{
    public const CITY_IDS = 'cityIds';

    public function rules(): array
    {
        return [
            self::CITY_IDS => ['required', 'array'],
            self::CITY_IDS . '.*' => ['required', 'integer', 'exists:cities,id'],
        ];
    }

    public function toDTO(): AirlineCityDTO
    {
        return new AirlineCityDTO(
            cityIds: (array) $this->input(self::CITY_IDS),
        );
    }
}
