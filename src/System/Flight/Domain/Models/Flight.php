<?php

declare(strict_types=1);

namespace Lightit\System\Flight\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\City\Domain\Models\City;

/**
 * Domain\System\Flight\Models\Flight
 *
 * @property int                             $id
 * @property int                             $airline_id
 * @property int                             $origin_city_id
 * @property int                             $destination_city_id
 * @property \Illuminate\Support\Carbon      $departure_datetime
 * @property \Illuminate\Support\Carbon      $arrival_datetime
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read Airline                    $airline
 * @property-read City                       $originCity
 * @property-read City                       $destinationCity
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Flight newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight query()
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereAirlineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereOriginCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereDestinationCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereDepartureDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereArrivalDateTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Flight whereUpdatedAt($value)
 *
 * @property-read City $destination
 * @property-read City $origin
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereArrivalDatetime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Flight whereDepartureDatetime($value)
 *
 * @mixin \Eloquent
 */
class Flight extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'departure_datetime' => 'datetime',
            'arrival_datetime' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return BelongsTo<Airline, $this>
     */
    public function airline(): BelongsTo
    {
        return $this->belongsTo(Airline::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function originCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    /**
     * @return BelongsTo<City, $this>
     */
    public function destinationCity(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
