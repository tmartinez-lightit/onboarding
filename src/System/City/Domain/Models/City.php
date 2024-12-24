<?php

declare(strict_types=1);

namespace Lightit\System\City\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\System\Airline\Domain\Models\Airline;
use Lightit\System\Flight\Domain\Models\Flight;

/**
 * Domain\System\City\Models\City
 *
 * @property int                             $id
 * @property string                          $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|City newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|City query()
 * @method static \Illuminate\Database\Eloquent\Builder|City whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|City whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Airline> $airlines
 * @property-read int|null $airlines_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $incomingFlights
 * @property-read int|null $incoming_flights_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $outgoingFlights
 * @property-read int|null $outgoing_flights_count
 *
 * @mixin \Eloquent
 */
class City extends Model
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    /**
     * @return HasMany<Flight, $this>
     */
    public function outgoingFlights(): HasMany
    {
        return $this->hasMany(Flight::class, 'origin_city_id');
    }

    /**
     * @return HasMany<Flight, $this>
     */
    public function incomingFlights(): HasMany
    {
        return $this->hasMany(Flight::class, 'destination_city_id');
    }

    /**
     * @return BelongsToMany<Airline, $this>
     */
    public function airlines(): BelongsToMany
    {
        return $this->belongsToMany(Airline::class);
    }
}
