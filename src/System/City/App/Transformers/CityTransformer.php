<?php

declare(strict_types=1);

namespace Lightit\System\City\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\City\Domain\Models\City;

class CityTransformer extends Transformer
{
    public function transform(City $city): array
    {
        return [
            'id' => $city->id,
            'name' => $city->name,
        ];
    }
}
