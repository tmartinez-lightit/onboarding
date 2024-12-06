<?php

declare(strict_types=1);

namespace Lightit\System\Airline\App\Transformers;

use Flugg\Responder\Transformers\Transformer;
use Lightit\System\Airline\Domain\Models\Airline;

class AirlineTransformer extends Transformer
{
    public function transform(Airline $airline): array
    {
        return [
            'id' => $airline->id,
            'name' => $airline->name,
            'description' => $airline->description,
        ];
    }
}
