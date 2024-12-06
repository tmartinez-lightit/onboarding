<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\System\City\Domain\DataTransferObjects\CityDTO;

class UpsertCityRequest extends FormRequest
{
    public const NAME = 'name';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:100', Rule::unique('cities')->ignore($this->route('city'))],
        ];
    }

    public function toDTO(): CityDTO
    {
        return new CityDTO(
            name: $this->string(self::NAME)->toString(),
        );
    }
}
