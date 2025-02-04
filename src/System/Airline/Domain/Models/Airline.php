<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Lightit\System\City\Domain\Models\City;
use Lightit\System\Flight\Domain\Models\Flight;

/**
 * Domain\Airlines\Models\Airline
 *
 * @property int                             $id
 * @property string                          $name
 * @property string|null                     $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Airline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline query()
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Airline whereUpdatedAt($value)
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $flights
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Flight> $activeFlights
 * @property-read int|null $active_flights_count
 * @property-read int|null $flights_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, City> $cities
 * @property-read int|null $cities_count
 *
 * @mixin \Eloquent
 */
class Airline extends Model
{
    /**
     * 	The attributes that aren't mass assignable.
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
     * @return BelongsToMany<City, $this>
     */
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class);
    }

    /** @return HasMany<Flight, $this> */
    public function flights(): HasMany
    {
        return $this->hasMany(Flight::class);
    }

    /** @return HasMany<Flight, $this> */
    public function activeFlights(): HasMany
    {
        return $this->hasMany(Flight::class)
            ->where('arrival_datetime', '>', now());
    }
}
