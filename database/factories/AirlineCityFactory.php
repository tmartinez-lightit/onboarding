<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Lightit\System\AirlineCity\Domain\Models\AirlineCity;

/**
 * @extends Factory<AirlineCity>
 */
class AirlineCityFactory extends Factory
{
    protected $model = AirlineCity::class;

    public function definition(): array
    {
        $airline = AirlineFactory::new()->createOne();
        $city = CityFactory::new()->createOne();

        return [
            'airline_id' => $airline->id,
            'city_id' => $city->id,
        ];
    }
}
