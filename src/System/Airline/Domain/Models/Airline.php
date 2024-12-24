<?php

declare(strict_types=1);

namespace Lightit\System\Airline\Domain\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Lightit\System\City\Domain\Models\City;

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
}
