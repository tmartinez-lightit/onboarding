<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Request;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Lightit\System\Airline\Domain\DataTransferObjects\AirlineDTO;

class UpsertAirlineRequest extends FormRequest
{
    public const NAME = 'name';

    public const DESCRIPTION = 'description';

    public function rules(): array
    {
        return [
            self::NAME => ['required', 'string', 'max:100', Rule::unique('airlines')->ignore($this->route('airline'))],
            self::DESCRIPTION => ['nullable', 'string'],
        ];
    }

    public function toDTO(): AirlineDTO
    {
        return new AirlineDTO(
            name: $this->string(self::NAME)->toString(),
            description: $this->string(self::DESCRIPTION)->toString(),
        );
    }
}
