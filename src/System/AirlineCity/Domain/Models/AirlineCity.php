<?php

declare(strict_types=1);

namespace Lightit\System\AirlineCity\Domain\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Lightit\System\City\Domain\Models\City;

/**
 * Domain\AirlineCity\Models\AirlineCity
 *
 * @property int                             $airline_id
 * @property int                             $city_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Airline $airline
 * @property-read City $city
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereAirlineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AirlineCity whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class AirlineCity extends Pivot
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'airline_city';

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
